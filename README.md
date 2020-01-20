###### averor/sf-messenger-ext-bundle

Adds some contracts, stamps and middlewares to the Symfony Messenger component.

##### Logging middleware:
Separate loggers for commands and events. Bundle provides interface only, logger must be implemented in App 
(examples provided in example/ dir)

##### Event Causation Middleware:
Event (envelope) will receive stamp with command id, that caused that event to happen. 
First handled command id is stored only, as a "root" cause of all that happened.

##### Exception Handling / Silencing  Middleware
Message dispatch process become contained in try...catch structure, all exceptions are logged via provided
`Psr\Log\LoggerInterface` instance. 
Event with exception details is send to provided `Symfony\Contracts\EventDispatcher\EventDispatcherInterface`.

Silencing version finishes its work here, while Handling one rethrow original exception.

##### Identifiable Message Middleware
Adds stamp with unique message id (`Ramsey\Uuid\Uuid`) to every message on bus, that middleware is attached to.