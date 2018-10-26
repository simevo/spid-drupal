# spid-drupal

**Drupal Module** per l'autenticazione attraverso un Identity Provider **SPID** (Sistema Pubblico di Identità Digitale) basato sulla libreria SPID PHP [italia/spid-php-lib](https://github.com/italia/spid-php-lib).

Compatibile con:
- Drupal  8.6.2
- PHP 7.0 e 7.2 


## Getting Started

Questa repo e' al momento una semplice proof of concept di autenticazione SPID all'interno del framework Drupal utilizzando la classe italia/spid-lib-php. Il modulo si connette con un server di test situato su [teamdigitale4.simevo.com](https://teamdigitale4.simevo.com) e ritorna i metadata dell'utente che ha eseguito il login [lista utenti di test](https://teamdigitale4.simevo.com/users)

### Installazione con Docker
Scaricare l'immagine Docker ufficiale di Drupal
```
docker pull drupal
```

Nel container, condividere /var/www/html/modules con il folder di sviluppo dell'host file system ed eseguire i seguenti comandi da terminale nel folder /modules:


```
git clone https://github.com/simevo/spid-drupal.git
cd spid-drupal/
composer install
```

Con l'immagine Docker in esecuzione cercare SPID Login ed installare il modulo da [estendi](http://localhost:8080/admin/modules).
A quel punto la path [/spid/login](http://localhost:8080/spid/login) permette l'autenticazione SSO sul server IDP di test [teamdigitale4.simevo.com](https://teamdigitale4.simevo.com)


## Contributing

Per contribuire a questo repo si prega di usare il [git-flow workflow](https://danielkummer.github.io/git-flow-cheatsheet/).

## Authors

Giulio gatto

## License

Copyright (c) 2018 simevo s.r.l.
Licenza: AGPL 3, vedi [LICENSE](LICENSE).
