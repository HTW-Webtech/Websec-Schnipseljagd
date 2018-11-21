---
title: Web Security
date: 2015-04-08
abgabe: [31. Juli, 31. Juli]
punkte: 3
---


Webanwendungen sind – da üblicherweise dauerhaft online und öffentlich erreichbar – leicht Angriffen ausgesetzt.

Im Rahmen dieser Übung stellen wir Ihnen einen sogenannten Honeypot zur Verfügung: einen Server mit Software, die bewusst Schwachstellen enthält.


---


Sie haben mitbekommen, dass Professor Heronimus unter [fiw-com.f4.htw-berlin.de/websec](http://fiw-com.f4.htw-berlin.de/websec) seine Übungszettel verwaltet. Gerüchten zufolge lagern dort sogar all seine Prüfungsaufgaben.


## Authentifizierung und Autorisierung

Wenn Sie die Adresse ansteuern, erscheint jedoch sofort ein Login-Formular. Das dazugehörige Passwort kennen Sie leider nicht.

> Versuchen Sie ein beliebiges Passwort.

Und auch die Versuche der häufigsten Varianten bleiben erfolglos.


## Information Disclosure

Doch ermutigt durch Ihre neu erworbenen Web-Tech-Fähigkeiten, sehen Sie sich den Code der Seite an.

> Öffnen Sie den Quelltext der Seite.

Hmm, anscheinend hat Prof. Heronimus den Rechtsklick gesperrt.

> Finden Sie einen anderen Weg, den Code der Seite anzeigen zu lassen. (Tipp: Im Browser über das passende Tastenkürzel oder über `curl` im Terminal.)

Im Quelltext der Seite finden Sie JavaScript-Code und sehen, dass dort sowohl das Passwort hinterlegt ist, als auch die Seite, zu der bei richtiger Eingabe weitergeleitet wird. Allerdings sehen beide Informationen seltsam aus – sind sie womöglich verschlüsselt?

Ihnen fallen die Funktionen `btoa()` und `atob()` auf, die sich um die kryptischen Zeichen legen.

> Belesen Sie sich unter [developer.mozilla.org](https://developer.mozilla.org/de/) über die Bedeutung dieser Funktionen.

Durch eine gezielte Web-Recherche finden Sie heraus, dass es sich dabei nicht um eine Verschlüsselung handelt, sondern nur eine Enkodierung.

Damit hat Prof. Heronimus wohl nicht gerechnet. Der Angriff scheint also denkbar einfach und der Zugang zum System zum Greifen nahe.

> Versuchen Sie das Passwort oder die URL du dekodieren, entweder im Terminal per `echo Zeichenkette | base64 --decode` oder direkt in der Konsole der Entwickler-Tools Ihres Browsers über die Funktion `atob('Zeichenkette')`

Sie können nun entweder das korrekte Passwort eingeben und sich weiterleiten lassen, oder direkt zur Zielseite springen.

Es stimmt also! Auf der Seite finden sich mehrere Übungszettel … aber keine Prüfungsaufgaben. Vielleicht woanders? Erkunden wir das Gebiet. Viele Seiten benutzen eine Datei namens _robots.txt_, um Suchmaschinen zu sagen, welche Verzeichnisse nicht indexiert werden sollen. Wir können diese Informationen nutzen, um eine erste Liste relevanter Verzeichnisse zu sammeln.

> Steuern Sie die Datei _robots.txt_ an.

Zwei Verzeichnisse springen uns sofort ins Auge: _admin_ und _dokumente_. Suchen wir noch etwas weiter.

> Gehen Sie zurück und sehen Sie sich den Quelltext der Seite an.

Die Aufgabenzettel werden anscheinend aus dem bereits bekannten Verzeichnis _dokumente_ geladen. Vielleicht liegen da auch die Prüfungsfragen?

> Steuern Sie das Verzeichnis _dokumente_ an.


## Directory Traversal

Es ist gesperrt. Sie kennen diese Art der Absicherung und wissen, dass sie üblicher Weise in einer Datei namens _.htaccess_ im selben Verzeichnis aktiviert wird. Und Sie erinnern sich, im Quelltext der vorherigen Seite eine Datei namens _show.php_ gesehen zu haben, die anscheinend die Übungsaufgaben in die Seite lädt. Vielleicht können wir ja auch unbeabsichtigte Dateinamen übergeben und deren Inhalt anzeigen lassen.

> Bringen Sie die _show.php_ dazu, Ihnen den Inhalt der _.htaccess_ anzuzeigen. <small>(Ihr Browser interpretiert den Text als HTML, wodurch Formatierung, z.B. Zeilenumbrüche, verloren geht. Lassen Sie sich den Quelltext der Seite anzeigen, um diesen Effekt zu umgehen.)</small>

Perfekt. Und wir sehen auch gleich, dass in `AuthUserFile` auf eine Datei mit den Zugangsdaten verwiesen wird.

> Lassen Sie sich den Inhalt der _.htpasswd_ anzeigen.

In der Datei finden wir die Zugangsdaten für eine Person: _heronimus_. Und dahinter sein Passwort.

> Versuchen Sie sich mit den Daten einzuloggen.


## Brute Force Attack

Anscheinend ist das nicht sein wirkliches Passwort, sondern eine verschlüsselte Version davon. Wir erinnern uns, dass es mehrere Möglichkeiten gibt, Passwörter in einer _.htpasswd_ zu hinterlegen, beispielsweise in Form von MD5- oder SHA1-Hashes. Allerdings tragen diese ein eindeutiges Prefix (`$apr1$` bzw. `{SHA}`). Da das hier nicht der Fall ist, bleibt noch die Verschlüsselung über den `crypt`-Algorithmus. Nach kurzer Recherche unter [httpd.apache.org](http://httpd.apache.org/docs/2.2/programs/htpasswd.html) finden Sie heraus, dass bei diesem Verfahren nur die ersten acht Zeichen eines Passworts berücksichtigt werden und so nehmen Sie sich vor, es mit einer Brute-Force-Attacke zu versuchen.

> Speichern Sie die Datei _.htpasswd_. Öffnen Sie danach das Terminal und installieren Sie das Programm _John the Ripper_ per `apt-get install john` oder `brew install john-jumbo`. (Oder besorgen Sie unter [openwall.com/john](http://www.openwall.com/john/) die geeignete Version für Ihr Betriebssystem.) Wechseln Sie in den Ordner, in der Sie die Datei gespeichert haben und starten Sie den Brute-Force-Angriff per `john .htpasswd`. Lehnen Sie sich zurück.[^john]

Nach ein paar Minuten erscheint im Terminal das gesuchte Passwort.

> Loggen Sie sich damit ein.

Sie finden die bereits bekannten Übungen und eine Datei namens _klausurfragen.txt_, die womöglich die Klausurfragen enthält.

Jetzt müssen wir es nur noch schaffen, die Datei zu bearbeiten. Sie erinnern sich, dass in der _robots.txt_ auch das Verzeichnis _admin_ stand.

> Navigieren Sie zu `/admin`.

Es erscheint wieder eine Login-Seite, diesmal geschützt durch Benutzernamen und Passwort.

> Versuchen Sie die bisher gefunden Zugangsdaten und untersuchen Sie den Quelltext der Seite nach hilfreichen Informationen für einen etwaigen Angriff.

Die Datei enthält keine offensichtlichen Angriffspunkte. Ist unser Vorhaben einem jähen Ende geweiht?


## Session Hijacking

Doch just in diesem Moment fällt Ihnen auf, dass ein Cookie gesetzt wurde in dem Sie den Schlüssel `PHPSESSID` finden.

Ihnen fällt wieder ein, dass es die Möglichkeit gibt, Cookies zu klauen. Unsere letzte Chance ist es also, an die autorisierte PHP-Session-ID des Professors zu kommen. Aber aufgrund der Same Origin Policy muss der Angriff von einer Seite derselben Herkunft erfolgen.

> Lesen Sie [de.wikipedia.org/wiki/Same-Origin-Policy](http://de.wikipedia.org/wiki/Same-Origin-Policy)

Aber wo platzieren wir das Script nur? Sie erinnern sich, dass der Professor Ihnen eine Seite gezeigt hat, auf der er Bilder seiner Mahlzeiten sammelt. Da diese Seite unter derselben Domain läuft, könnte es sein, dass Sie – wenn Sie es trickreich genug anstellen – darüber seinen Cookie stibitzen könnten.

> Navigieren Sie zu der Seite [fiw-com.f4.htw-berlin.de/websec/foodlog/](http://fiw-com.f4.htw-berlin.de/websec/foodlog/) und von dort in das Unterverzeichnis _admin_.


## SQL Injection

Sie sehen wieder ein Login-Formular. Die Seite ist etwas älter – vielleicht hat Prof. Heronimus hier nicht mit einem Angriff gerechnet und war bei der Sicherheit nachlässig.

> Versuchen Sie, über die Eingabefelder SQL-Code einzuschleusen und so die Login-Abfrage auszutricksen. <small>(Hilfe gibt es in den Vorlesungsfolien.)</small>


## Remote Code Execution

Geschafft – Sie sind drin! Welch süßer Sieg. Sie sehen nun ein Upload-Formular. Jetzt noch schnell das Skript platzieren.

> Zur Hilfe bekommen Sie das Archiv [Kekse.zip](http://fiw-com.f4.htw-berlin.de/websec/kekse/) – laden Sie es herunter, entpacken Sie es und laden Sie die darin enthaltene Datei _keksdieb.js_ im Foodlog hoch.

Das Formular lässt anscheinend nur Bild-Dateien zu. Hmm. Eventuell können wir einen Fehler produzieren, um an mehr Informationen zu kommen?

> Öffnen Sie in Ihrem Browser die Developer-Tools (Rechtsklick auf das Inputfeld → "Element untersuchen") und entfernen Sie das Input-Element mit dem Typ `file`, indem Sie in dem sich öffnenden Fenster den entsprechenden Eintrag auswählen und auf Entfernen drücken. Sie sehen, wie es sofort aus der Website verschwindet. Starten Sie nun erneut einen Upload, indem Sie auf _Hinzufügen_ klicken.


## Information Disclosure

Aha! Sie bekommen eine Fehlermeldung. Und in guter Absicht wird der Teil des Codes angezeigt, in dem der Fehler aufgetreten ist. Anscheinend findet bei einem Upload an dieser Stelle die Prüfung der Dateiendung statt, um sicherzustellen, dass nur Bilder mit der Endung `.jpg` durchkommen. Aber es wirkt zu einfach.

> Lesen Sie [The absolute bare minimum every programmer should know about regular expressions](http://web.archive.org/web/20090226052234/http://immike.net/blog/2007/04/06/the-absolute-bare-minimum-every-programmer-should-know-about-regular-expressions/).


## Input Validation

Heureka! Der reguläre Ausdruck enthält eine fast unscheinbare Nachlässigkeit: Der Dateiname wird mit `/\.jpg/i` verglichen – aber dadurch, dass das Muster nicht mit einem Dollarzeichen abschließt (`/\.jpg$/i`), wird nicht explizit geprüft, ob die vermeintliche Dateiendung auch wirklich am Ende steht.

Der Puls steigt – doch bevor es losgeht, brauchen wir noch eine Datei, die unseren geklauten Cookie entgegennimmt.

> Kopieren Sie die Datei _keksdose.php_ in den Ordner _public_html_ in Ihrem Studi-Verzeichnis und machen Sie sie ausführbar. Rufen Sie die Datei über Ihre Studi-Adresse auf und hängen Sie zum Testen einen Parameter an, beispielsweise `https://studi.f4.htw-berlin.de/~s543210/keksdose.php?sonne=schoen`.

Hat alles funktioniert, wurde eine neue Datei namens _keksdose.txt_ angelegt, in der die eben übergebenen Daten enthalten sind. Jetzt müssen wir nur noch die JavaScript-Datei anpassen und hochladen.

> Öffnen Sie die Datei _keksdieb.js_ und ändern Sie die darin enthaltene Adresse in der Variable `url` auf die Web-Adresse, unter der Ihre Keksdose erreichbar ist. Nennen Sie die Datei danach um und ändern Sie dabei das Wort "keksdieb" zu Ihrer Matrikelnummer und die Dateiendung auf `.jpg.js`. Anschließend können Sie die Datei auf Prof. Heronimus' Seite hochladen.


## Cross-Site Scripting

Geschafft! Jetzt müssen wir das Skript nur noch auf einer Website einbinden und sie vom Professor besuchen lassen.

> Navigieren Sie zu der Adresse Ihres Skripts (`foodlog/images/s0543210.jpg.js`) und speichern Sie die URL.

Sie erinnern sich an die Möglichkeit eines sogenannten Cross-Site-Scripting-Angriffs.

> Lesen Sie [de.wikipedia.org/wiki/Cross-Site-Scripting](http://de.wikipedia.org/wiki/Cross-Site-Scripting)

… aber wo finden wir ein geeignetes Ziel, um Code einzuschleusen?

Da gibt es doch diesen Grußkarten-Dienst unter [fiw-com.f4.htw-berlin.de/websec/karte/](http://fiw-com.f4.htw-berlin.de/websec/karte/), auf dem Karten-Motive beschrieben und mit anderen geteilt werden können. Der URL-Parameter `text` wird anscheinend ohne weitere Filterung übernommen und ist damit für einen reflektiven XSS-Angriff geeignet.

> Gehen Sie auf die Website, wählen Sie ein Motiv aus, schreiben Sie einen passenden Text in die URL und fügen Sie HTML-Code zum Einbinden Ihrer umbenannten _keksdieb.js_ an. <small>(Achten Sie dabei auf nötige Kodierungen.)</small> Testen Sie das Ganze. <small>(Und speichern Sie die URL vorsichtshalber zwischen – das Skript entfernt den Schadcode automatisch aus der Adresse, um den Angriff zu verschleiern.)</small>

Klasse! Unser Angriff könnte wirklich funktionieren. Jetzt müssen wir Professor Heronimus nur noch die präparierte URL schicken. Allerdings dürfen wir nicht auffallen und er könnte womöglich den Code in der manipulierten URL erkennen. Aber auch hierfür gibt es einen Trick!

> Besuchen Sie die Seite [bitly.com](https://bitly.com/) und lassen Sie sich eine Stellvertreter-URL für die manipulierte Adresse geben. Dieser ist der ursprüngliche Inhalt nicht mehr anzusehen. Schicken Sie eine E-Mail mit dem Link und lieben Grüßen an den Professor ([prof-heronimus@lists.htw-berlin.de](mailto:prof-heronimus@lists.htw-berlin.de)) und warten Sie, bis sein Cookie in Ihrer _keksdose.txt_ landet. <small>(Er antwortet Ihnen manuell; das kann etwas dauern.)</small>

{:.centered}
…

Eiferbibsch! Es hat funktioniert. Der Professor hat sich für die nette Karte bedankt und Sie finden die gesuchte Session-ID in Ihrer Keksdose. Jetzt müssen Sie nur noch Ihren Cookie durch den erbeuteten ersetzen und kommen in den Admin-Bereich der Seite des Professors.

> Besuche Sie [fiw-com.f4.htw-berlin.de/websec/admin/](http://fiw-com.f4.htw-berlin.de/websec/admin/), öffnen Sie wieder Ihre Dev-Tools und fügen Sie über die Konsole die neue `PHPSESSID` Ihren Cookies hinzu:

```js
document.cookie = 'PHPSESSID=<neue id>';
```

> Laden Sie die Seite danach neu.

Sapperlot, hier verwaltet der Professor also seine Prüfungsfragen. Na dann schummeln wir ihm mal die ein oder andere eigene Frage unter …
<small>(Mit dem Eintragen in die Hall of Fame ist die Aufgabe bestanden.)</small>

<br>

{:.centered}
**Herzlichen Glückwunsch!**

<br>

<small>Und denken Sie daran, dass Sie sich strafbar machen, wenn Sie diese oder andere Angriffe ohne Erlaubnis der Webseitenbetreiberin durchführen. (Strafgesetzbuch: [§ 202c Vorbereiten des Ausspähens und Abfangens von Daten](http://www.gesetze-im-internet.de/stgb/__202c.html), [§ 303a
Datenveränderung](http://www.gesetze-im-internet.de/stgb/__303a.html) und [§ 303b Computersabotage](http://www.gesetze-im-internet.de/stgb/__303b.html))</small>


## Wer mehr wissen möchte

* [Natas – Web-Security-Spiel](http://overthewire.org/wargames/natas/)
* [Googles XSS Game](https://xss-game.appspot.com/)
* [OWASP – Open Web Application Security Project](https://www.owasp.org/index.php/Main_Page)
* [Browser Security Handbook](https://code.google.com/p/browsersec/wiki/Main)
* [Stripe Capture the Flag: Web Edition](https://github.com/stripe-ctf/stripe-ctf-2.0/)


---

[^john]: Unter 1.79 dauerte es bei mir um die fünf Minuten, mit 1.8 sind es Stunden. Keine Ahnung warum. Dafür können Sie nun unter Unix mit `--fork=N` angeben, wie viele Kerne parallel genutzt werden sollen. Wer es lieber mit 1.79 versuchen möchte, findet unter [openwall.info/wiki/john/custom-builds](http://openwall.info/wiki/john/custom-builds) entsprechende Pakete.
