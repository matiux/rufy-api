Documentazione: [qui](https://bitbucket.org/rufyteam/rufy-rest-api/wiki)

# TODO: #
* Provare a creare un controller come servizio con metodi condivisi
- Rifattorizzare l'utilizzo dell'handler nei controller - Controllare ma direi che è a posto
+ Controllo Servizi / Injection con firma con interfacce - Controllare ma direi che è a posto
- Implementazione auth con token piuttosto che basic: [info](http://symfony.com/it/doc/current/cookbook/security/api_key_authentication.html)
- Sistemare setTableDimension() e setTablePosition() nel salvataggio della reservation
- Bloccare cors solo per il client
- Durante un PATCH, se si vuole cambiare l'area, trovare il modo di cancellare prima le opzioni della
- prenotazione che non appartengono alla nuova area
- Controllo numero query POST
- Controllo numero query PATCH
- Provare a togliere onPrePersist() da Reservation e quindi forse anche i trasformatori nel form
- Voter hasUser() aree
- Test aggiornamento Reservation
- Log giornalieri
