<?php

declare(strict_types=1);
?><!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Archivo privado en Amazon S3 con cifrado SSE-KMS y acceso autorizado desde PHP.">
    <title>Aegis Cloud Archive · Laboratorio 14</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<header class="site-header">
    <nav class="shell nav" aria-label="Navegación principal">
        <a class="brand" href="#inicio" aria-label="Aegis Cloud Archive, inicio">
            <span class="brand-mark"><i></i><b>A</b></span>
            <span class="brand-copy"><strong>Aegis Cloud Archive</strong><small>ARCHIVO PRIVADO EN LA NUBE</small></span>
        </a>
        <div class="nav-links"><a class="active" href="#inicio">Inicio</a><a href="#archivo">Archivo seguro</a><a href="#arquitectura">Arquitectura</a><a href="#evidencia">Evidencia</a></div>
        <a class="button button-small" href="#archivo">Ver demostración <span>→</span></a>
    </nav>
</header>

<main>
    <section class="hero" id="inicio">
        <div class="hero-shade"></div>
        <div class="shell hero-inner">
            <div class="hero-copy">
                <p class="eyebrow"><span></span>AWS S3 + SSE-KMS</p>
                <h1>Archivos privados.<br><em>Acceso bajo control.</em></h1>
                <p class="hero-lead">Protegemos contenido sensible en Amazon S3 con cifrado y acceso autorizado desde la aplicación.</p>
                <div class="hero-actions"><a class="button" href="#archivo">Ver demostración <span>→</span></a><a class="ghost-button" href="#arquitectura"><i>▶</i> Cómo funciona</a></div>
                <div class="proof-row"><span><b id="metric-region">us-east-2</b> Región activa</span><span><b id="metric-status">Verificando…</b> Estado de conexión</span></div>
            </div>
        </div>
        <div class="shell feature-rail" aria-label="Características de seguridad">
            <article><svg viewBox="0 0 48 48" aria-hidden="true"><ellipse cx="24" cy="10" rx="15" ry="6"/><path d="M9 10v12c0 3 7 6 15 6s15-3 15-6V10M9 22v12c0 3 7 6 15 6s15-3 15-6V22"/></svg><strong>Almacenamiento privado</strong></article>
            <article><svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="29" cy="16" r="9"/><path d="m23 22-15 15m4-4 4 4m1-10 4 4m14-21-6 6"/></svg><strong>Cifrado SSE-KMS</strong></article>
            <article><svg viewBox="0 0 48 48" aria-hidden="true"><path d="M24 4c5 4 10 5 15 6v12c0 10-6 17-15 22C15 39 9 32 9 22V10c5-1 10-2 15-6Z"/><path d="m17 24 5 5 10-11"/></svg><strong>Acceso autorizado</strong></article>
        </div>
    </section>

    <section class="secure-section" id="archivo">
        <div class="shell secure-intro">
            <div><p class="eyebrow"><span></span>OBJETO CIFRADO EN REPOSO</p><h2>Seguridad simple<br>de <em>entender.</em></h2><p>Un archivo privado en la nube con cifrado y control de acceso, listo para tus aplicaciones.</p></div>
            <div class="secure-visual">
                <div class="photo-frame">
                    <div id="media-loader" class="media-loader"><span></span><p>Solicitando objeto protegido…</p></div>
                    <img id="secure-media" src="api/media.php" alt="Archivo fotográfico privado recuperado desde Amazon S3">
                    <div id="media-error" class="media-error" hidden><b>Recurso no disponible</b><span>Comprueba la sesión de AWS.</span></div>
                    <div class="photo-caption"><span>ARCHIVO PRIVADO · AMAZON S3</span><b id="object-size">—</b></div>
                </div>
                <span class="cloud-lock" aria-hidden="true"><i></i></span>
            </div>
        </div>

        <div class="shell status-panel" id="evidencia">
            <div><small>VERIFICACIÓN EN VIVO</small><h3>Protección confirmada</h3><p>Metadatos consultados directamente desde el objeto almacenado.</p></div>
            <dl><div><dt>Bucket privado</dt><dd id="status-bucket">Verificando…</dd></div><div><dt>Cifrado activo</dt><dd id="status-encryption">—</dd></div><div><dt>Clave KMS</dt><dd id="status-key">—</dd></div><div><dt>Última validación</dt><dd id="status-time">—</dd></div></dl>
            <button id="refresh-media" type="button">Actualizar recurso ↻</button>
        </div>
    </section>

    <section class="architecture" id="arquitectura">
        <div class="shell">
            <p class="eyebrow"><span></span>FLUJO DE PROTECCIÓN</p>
            <div class="architecture-heading"><h2>El navegador ve el archivo.<br><em>No ve las credenciales.</em></h2><p>La aplicación PHP mantiene la identidad en el servidor y solicita el objeto cifrado mediante el SDK de AWS.</p></div>
            <div class="process-line">
                <article><span>01</span><b>WEB</b><h3>Solicitud</h3><p>El usuario solicita el recurso protegido.</p></article>
                <i>→</i><article><span>02</span><b>PHP</b><h3>Identidad</h3><p>El backend obtiene credenciales seguras.</p></article>
                <i>→</i><article><span>03</span><b>S3</b><h3>Objeto privado</h3><p>S3 valida el permiso sobre el archivo.</p></article>
                <i>→</i><article><span>04</span><b>KMS</b><h3>Descifrado</h3><p>KMS autoriza la clave y entrega el contenido.</p></article>
            </div>
        </div>
    </section>
</main>

<footer><div class="shell"><div class="brand brand-footer"><span class="brand-mark"><i></i><b>A</b></span><span class="brand-copy"><strong>Aegis Cloud Archive</strong><small>LABORATORIO 14 · 2026</small></span></div><p>Seguridad en servicios AWS · Entorno académico</p></div></footer>
<script src="assets/app.js" defer></script>
</body>
</html>
