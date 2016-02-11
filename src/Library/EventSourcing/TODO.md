# Milhojas Event Sourcing To Do List

## Naming things

√ Milhojas/EventSourcing/EventStore/Event is a bad name. It should be better EventDAO.

Milhojas/EventSourcing/EventStore/EntityDTO is also a bad name. It could be better EntityData or EntityInformation oe EventSourcedEntityInformation. Not sure about this.

## Separation of concerns

EventMessage and EventMessageEnvelope should accept this EntityData object instead of EventSourced. We don't work with entities in this layer (infrastructure), but we need some entity information.

Entity information is redundant in several parts. We should check if this redundancy in acceptable or not.

Consider to organize code based on architecture (domain/application/infrastructure)

## Things to do

CommandBus Decorator to manage Events

Version management. We need several things

Entities should know their current version. So, when you reconstitue an entity it should state its current version number.

A entity should estimate its version number after a series of events is applied, and check if this is the right version before store, beacause it could a conflcit with the last version stored. So EventMessages should be aware of version.

EventMessage / EventMessageEnvelope and EventDAO seems too many classes for the task. We should question if this is neccesary. Perhaps  EventDAO and EventMessageEnvelope should be the same class or some 1:1 relation.

I think the events in EventSourceEntity should be an EventStream with append options. To think: EventStream taking care of create itself the EventMeesageEnveloped... ???