# Websec-Schnipseljagd

Ziel ist es, Studierende praktisch mit typischen Sicherheitslücken im Web und möglichen Angriffen über diese vertraut zu machen. Dazu können sie anhand eines vorgegebenen Angriffs Schritt für Schritt Zugriff auf die vermeintlichen Fragen der Abschlussprüfung des Kurses erlangen und letztlich sogar eigene hinzufügen. (In unserem Falle finden sich geeignete Fragen auch wirklich in der Prüfung wieder.)


## Installation und Bereitstellung

Es wird nur ein Apache-Webserver mit PHP-Unterstützung benötigt, allerdings müssen einige Details angepasst werden:

- Der Pfad zum `AuthUserFile` in der Datei `dokumente/.htaccess` muss absolut sein und entsprechend bearbeitet werden.

- Das Admin-Passwort in `admin/index.php` sollte geändert werden.

- Die Anleitung für die Studierenden findet sich in der Datei `Websec.md`. Ändern Sie hier alle URLs mit der Domain `fiw-com.f4.htw-berlin.de` entsprechend Ihrer eigenen Konfiguration. Zudem muss die Email-Adresse `prof-heronimus@lists.htw-berlin.de` auf eine eigene Adresse geändert werden.

- Die Datei `kekse/keksdose.php` muss von den Studierenden im Web bereitgestellt werden – hierfür muss eine Möglichkeit geschaffen und der Hinweistext entsprechend umgeschrieben werden.


## Feedback

Bei Fragen oder Hinweisen können Sie eine E-Mail an maximilian.beier@htw-berlin.de schicken. Bei Fehlern oder Ergänzungen legen Sie bitte ein Issue oder Pull Requests an.
