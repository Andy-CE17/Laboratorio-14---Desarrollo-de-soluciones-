<?php

declare(strict_types=1);
?><!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Demostración de seguridad en AWS: contenido privado de S3 cifrado con KMS.">
    <title>Aegis Vault · Laboratorio 14</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<div class="ambient ambient-one"></div>
<div class="ambient ambient-two"></div>

<header class="topbar">
    <a class="brand" href="#inicio" aria-label="Aegis Vault, inicio">
        <span class="brand-mark" aria-hidden="true">
            <svg viewBox="0 0 40 40" role="img"><path d="M20 3 34 9v10c0 8.8-5.8 15.4-14 18-8.2-2.6-14-9.2-14-18V9l14-6Z"/><path d="M14 19.5 18.2 24 27 14.8"/></svg>
        </span>
        <span>Aegis<span>Vault</span></span>
    </a>
    <nav aria-label="Navegación principal">
        <a href="#archivo">Archivo protegido</a>
        <a href="#arquitectura">Arquitectura</a>
        <a href="#evidencia">Evidencia</a>
    </nav>
    <div class="lab-badge"><span></span> Laboratorio 14</div>
</header>

<main id="inicio">
    <section class="hero section-shell">
        <div class="hero-copy">
            <div class="eyebrow"><span></span> SEGURIDAD EN SERVICIOS AWS</div>
            <h1>Tu contenido privado,<br><em>protegido por diseño.</em></h1>
            <p class="hero-lead">Una demostración real de cifrado en reposo: Amazon S3 conserva el archivo, AWS KMS controla su clave y PHP lo entrega únicamente a identidades autorizadas.</p>
            <div class="hero-actions">
                <a class="button button-primary" href="#archivo">Ver archivo seguro <span>↘</span></a>
                <a class="button button-ghost" href="#arquitectura">Explorar el flujo</a>
            </div>
            <div class="trust-row" aria-label="Características de seguridad">
                <span><b>01</b> Bucket privado</span>
                <span><b>02</b> Cifrado SSE-KMS</span>
                <span><b>03</b> Acceso controlado</span>
            </div>
        </div>

        <div class="hero-visual" aria-label="Representación del archivo protegido">
            <div class="orbit orbit-one"></div>
            <div class="orbit orbit-two"></div>
            <div class="vault-core">
                <div class="core-grid"></div>
                <svg class="shield-large" viewBox="0 0 100 116" aria-hidden="true">
                    <path d="M50 4 91 21v29c0 29-16.8 50.7-41 61C25.8 100.7 9 79 9 50V21L50 4Z"/>
                    <path d="m31 57 12 12 27-29"/>
                </svg>
            </div>
            <div class="data-chip chip-top"><span>AES</span><b>256</b></div>
            <div class="data-chip chip-bottom"><span>STATUS</span><b>ENCRYPTED</b></div>
            <div class="visual-caption">Cifrado de nivel empresarial<br><span>Clave administrada en AWS KMS</span></div>
        </div>
    </section>

    <section class="metrics section-shell" aria-label="Resumen del laboratorio">
        <article><span class="metric-icon">◆</span><div><small>ALMACENAMIENTO</small><strong>Amazon S3</strong></div></article>
        <article><span class="metric-icon">⌁</span><div><small>CIFRADO</small><strong>SSE-KMS</strong></div></article>
        <article><span class="metric-icon">◎</span><div><small>REGIÓN</small><strong id="metric-region">us-east-2</strong></div></article>
        <article><span class="pulse-dot"></span><div><small>CONEXIÓN</small><strong id="metric-status">Verificando…</strong></div></article>
    </section>

    <section class="secure-section section-shell" id="archivo">
        <div class="section-heading">
            <div><div class="eyebrow"><span></span> OBJETO CIFRADO</div><h2>La evidencia, servida de forma segura.</h2></div>
            <p>El navegador nunca recibe credenciales de AWS. PHP solicita el objeto desde el servidor utilizando una identidad autorizada.</p>
        </div>

        <div class="media-layout">
            <article class="media-card">
                <div class="media-toolbar">
                    <div class="window-dots"><i></i><i></i><i></i></div>
                    <span>VISTA AUTORIZADA</span>
                    <button id="refresh-media" type="button" aria-label="Actualizar archivo">↻</button>
                </div>
                <div class="media-frame">
                    <div class="media-loader" id="media-loader"><span></span><p>Descifrando recurso con AWS KMS…</p></div>
                    <img id="secure-media" src="api/media.php" alt="Ilustración privada recuperada desde Amazon S3 con cifrado KMS">
                    <div class="media-error" id="media-error" hidden><strong>Acceso no disponible</strong><p>Verifica la configuración de S3 y los permisos de la clave KMS.</p></div>
                </div>
                <div class="media-meta"><span>PRIVATE OBJECT</span><span id="object-size">—</span></div>
            </article>

            <aside class="security-panel" id="evidencia">
                <div class="panel-kicker">INFORMACIÓN DE SEGURIDAD</div>
                <h3>Cadena de protección</h3>
                <p class="panel-intro">Metadatos obtenidos directamente del objeto almacenado en AWS.</p>
                <dl class="status-list">
                    <div><dt><span class="status-icon">S3</span> Bucket privado</dt><dd id="status-bucket">Verificando…</dd></div>
                    <div><dt><span class="status-icon">K</span> Método de cifrado</dt><dd id="status-encryption">—</dd></div>
                    <div><dt><span class="status-icon">#</span> Clave KMS</dt><dd id="status-key">—</dd></div>
                    <div><dt><span class="status-icon">◷</span> Última validación</dt><dd id="status-time">—</dd></div>
                </dl>
                <div class="verified-stamp"><svg viewBox="0 0 24 24"><path d="m5 12 4 4L19 6"/></svg><div><strong>Protección verificada</strong><span>El archivo permanece cifrado en reposo.</span></div></div>
            </aside>
        </div>
    </section>

    <section class="architecture section-shell" id="arquitectura">
        <div class="section-heading compact">
            <div><div class="eyebrow"><span></span> ARQUITECTURA</div><h2>Una solicitud. Tres capas de confianza.</h2></div>
        </div>
        <div class="flow" aria-label="Flujo de acceso seguro">
            <article><span class="step">01</span><div class="flow-icon">&lt;/&gt;</div><h3>Aplicación PHP</h3><p>Recibe la solicitud sin exponer secretos ni credenciales al navegador.</p></article>
            <div class="flow-line"><span>HTTPS</span></div>
            <article><span class="step">02</span><div class="flow-icon">S3</div><h3>Amazon S3</h3><p>Valida la identidad y localiza el objeto dentro del bucket privado.</p></article>
            <div class="flow-line"><span>DECRYPT</span></div>
            <article><span class="step">03</span><div class="flow-icon">KMS</div><h3>AWS KMS</h3><p>Autoriza el uso de la clave y descifra el contenido de forma transparente.</p></article>
        </div>
    </section>
</main>

<footer class="section-shell">
    <div class="brand footer-brand"><span class="brand-mark mini">✓</span><span>Aegis<span>Vault</span></span></div>
    <p>Laboratorio 14 · Desarrollo de Soluciones en la Nube</p>
    <span>Entorno académico · Sin datos sensibles</span>
</footer>

<script src="assets/app.js" defer></script>
</body>
</html>

