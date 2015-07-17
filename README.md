# Websec-Schnipseljagd

Ziel ist es, Studierende praktisch mit typischen Sicherheitslücken im Web und möglichen Angriffen über diese vertraut zu machen. Dazu können sie anhand eines vorgegebenen Angriffs Schritt für Schritt Zugriff auf die vermeintlichen Fragen der Abschlussprüfung des Kurses erlangen und letztlich sogar eigene hinzufügen. (In unserem Falle finden sich geeignete Fragen auch wirklich in der Prüfung wieder.)


## Installation und Bereitstellung

Es wird nur ein Apache-Webserver mit PHP-Unterstützung (und `php5-sqlite`) benötigt, allerdings müssen einige Details angepasst werden:

- Der Pfad zum `AuthUserFile` in der Datei `dokumente/.htaccess` muss absolut sein und entsprechend bearbeitet werden.

- Die Dateien `hall_of_fame.csv` und `dokumente/klausurfragen.txt` und die Verzeichnisse `assets/sessions` und `foodlog/images` müssen schreibbar sein.

- Die Passwörter in `admin/index.php` und `.htpasswd` sollten geändert werden (letzteres per crypt(3), bspw. durch `openssl passwd -crypt passw0rt`).

- Die Anleitung für die Studierenden findet sich in der Datei `Websec.md`. Ändern Sie hier alle URLs mit der Domain `fiw-com.f4.htw-berlin.de` entsprechend Ihrer eigenen Konfiguration. Zudem muss die Email-Adresse `prof-heronimus@lists.htw-berlin.de` auf eine eigene Adresse geändert werden.

- Die Datei `kekse/keksdose.php` muss von den Studierenden im Web bereitgestellt werden – hierfür muss eine Möglichkeit geschaffen und der Hinweistext entsprechend umgeschrieben werden.


## Feedback

Bei Fragen oder Hinweisen können Sie eine E-Mail an maximilian.beier@htw-berlin.de schicken. Bei Fehlern oder Ergänzungen legen Sie bitte ein Issue oder Pull Requests an.
