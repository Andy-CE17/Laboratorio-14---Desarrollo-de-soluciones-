# Laboratorio 14 — Seguridad en servicios AWS

Demostración web en PHP que recupera un objeto privado de Amazon S3 cifrado con una clave administrada en AWS KMS.

## Arquitectura

1. El navegador solicita el recurso a `public/api/media.php`.
2. PHP utiliza el SDK oficial de AWS y la cadena segura de credenciales del entorno.
3. Amazon S3 valida los permisos sobre el objeto.
4. AWS KMS autoriza el descifrado y S3 devuelve el contenido a PHP.

El proyecto **no contiene claves de acceso de AWS**. En una instancia EC2 se debe asignar un rol IAM; en desarrollo local se utiliza una sesión autenticada de AWS CLI.

## Requisitos

- PHP 8.2 o superior.
- Composer.
- Una identidad AWS con permisos mínimos sobre el objeto de S3 y la clave KMS.

## Instalación

```bash
composer install
```

Copia `config/local.php.example` como `config/local.php` o define las variables indicadas en `.env.example`.

```bash
composer serve
```

Abre `http://127.0.0.1:8080`.

## Seguridad

- Bucket con acceso público bloqueado.
- Cifrado predeterminado SSE-KMS.
- TLS obligatorio mediante política del bucket.
- Credenciales proporcionadas por un rol IAM o la cadena de proveedores del SDK.
- `config/local.php` y `.env` están excluidos de Git.

