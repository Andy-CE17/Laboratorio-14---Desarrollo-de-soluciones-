<?php

declare(strict_types=1);

namespace Lab14;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use RuntimeException;

final class SecureMediaService
{
    private S3Client $s3;
    private string $bucket;
    private string $key;

    public function __construct()
    {
        $region = $this->requiredEnv('AWS_REGION');
        $this->bucket = $this->requiredEnv('S3_BUCKET');
        $this->key = $this->requiredEnv('S3_OBJECT_KEY');

        $this->s3 = new S3Client([
            'region' => $region,
            'version' => 'latest',
        ]);
    }

    /** @return array{body: mixed, contentType: string, etag: string} */
    public function getMedia(): array
    {
        try {
            $result = $this->s3->getObject([
                'Bucket' => $this->bucket,
                'Key' => $this->key,
            ]);

            return [
                'body' => $result['Body'],
                'contentType' => (string) ($result['ContentType'] ?? 'application/octet-stream'),
                'etag' => trim((string) ($result['ETag'] ?? ''), '"'),
            ];
        } catch (AwsException $exception) {
            throw new RuntimeException($this->friendlyMessage($exception), 0, $exception);
        }
    }

    /** @return array<string, string|int|bool|null> */
    public function getStatus(): array
    {
        try {
            $object = $this->s3->headObject([
                'Bucket' => $this->bucket,
                'Key' => $this->key,
            ]);

            $encryption = (string) ($object['ServerSideEncryption'] ?? 'Sin información');

            return [
                'available' => true,
                'bucket' => $this->bucket,
                'object' => $this->key,
                'region' => $this->requiredEnv('AWS_REGION'),
                'encryption' => $encryption === 'aws:kms' ? 'SSE-KMS' : $encryption,
                'kmsKeyId' => $this->shortKey((string) ($object['SSEKMSKeyId'] ?? '')),
                'contentType' => (string) ($object['ContentType'] ?? 'Desconocido'),
                'size' => (int) ($object['ContentLength'] ?? 0),
                'lastModified' => isset($object['LastModified'])
                    ? $object['LastModified']->format(DATE_ATOM)
                    : null,
            ];
        } catch (AwsException $exception) {
            throw new RuntimeException($this->friendlyMessage($exception), 0, $exception);
        }
    }

    private function requiredEnv(string $name): string
    {
        $value = getenv($name);
        if ($value === false || trim($value) === '') {
            throw new RuntimeException(sprintf('Falta configurar la variable %s.', $name));
        }

        return trim($value);
    }

    private function shortKey(string $key): string
    {
        if ($key === '') {
            return 'No disponible';
        }

        $segments = explode('/', $key);
        $id = end($segments) ?: $key;
        return strlen($id) > 18 ? substr($id, 0, 8) . '…' . substr($id, -8) : $id;
    }

    private function friendlyMessage(AwsException $exception): string
    {
        return match ($exception->getAwsErrorCode()) {
            'AccessDenied', 'AccessDeniedException' => 'AWS rechazó el acceso. Revisa los permisos de S3 y KMS.',
            'NoSuchKey' => 'El archivo seguro no existe en el bucket configurado.',
            'NoSuchBucket' => 'El bucket configurado no existe.',
            'KMSAccessDeniedException' => 'La identidad actual no puede descifrar con la clave KMS.',
            default => 'No fue posible recuperar el recurso protegido desde AWS.',
        };
    }
}

