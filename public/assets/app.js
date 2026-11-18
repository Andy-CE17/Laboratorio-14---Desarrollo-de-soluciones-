const $ = (selector) => document.querySelector(selector);

const formatBytes = (bytes) => {
  if (!Number.isFinite(bytes) || bytes <= 0) return '—';
  const units = ['B', 'KB', 'MB'];
  const index = Math.min(Math.floor(Math.log(bytes) / Math.log(1024)), units.length - 1);
  return `${(bytes / 1024 ** index).toFixed(index ? 1 : 0)} ${units[index]}`;
};

const maskBucket = (value) => {
  if (!value) return '—';
  return value.length > 26 ? `${value.slice(0, 17)}…${value.slice(-6)}` : value;
};

async function loadStatus() {
  try {
    const response = await fetch('api/status.php', { cache: 'no-store' });
    const payload = await response.json();
    if (!response.ok || !payload.ok) throw new Error(payload.message || 'Sin conexión');

    const data = payload.data;
    $('#metric-status').textContent = 'Protegida';
    $('#metric-status').closest('article').classList.add('online');
    $('#metric-region').textContent = data.region;
    $('#status-bucket').textContent = maskBucket(data.bucket);
    $('#status-encryption').textContent = data.encryption;
    $('#status-key').textContent = data.kmsKeyId;
    $('#status-time').textContent = new Intl.DateTimeFormat('es-PE', {
      hour: '2-digit', minute: '2-digit', second: '2-digit'
    }).format(new Date());
    $('#object-size').textContent = formatBytes(data.size);
  } catch (error) {
    $('#metric-status').textContent = 'Sin conexión';
    $('#status-bucket').textContent = 'No disponible';
    $('#status-encryption').textContent = '—';
    $('#status-key').textContent = '—';
    console.error(error);
  }
}

const image = $('#secure-media');
const loader = $('#media-loader');
const errorState = $('#media-error');

const showLoadedMedia = () => {
  loader.hidden = true;
  errorState.hidden = true;
  image.hidden = false;
  image.classList.add('ready');
};

image.addEventListener('load', showLoadedMedia);

image.addEventListener('error', () => {
  loader.hidden = true;
  image.hidden = true;
  errorState.hidden = false;
});

$('#refresh-media').addEventListener('click', () => {
  image.hidden = false;
  image.classList.remove('ready');
  errorState.hidden = true;
  loader.hidden = false;
  image.src = `api/media.php?t=${Date.now()}`;
  loadStatus();
});

if (image.complete && image.naturalWidth > 0) {
  showLoadedMedia();
}

loadStatus();

