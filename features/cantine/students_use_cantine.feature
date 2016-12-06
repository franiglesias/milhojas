Feature: Students want to use cantine service
    As a Student
    I want to buy tickets for cantine
    In order to eat on specific dates
    Rules:
    - All Users:
    - could provide an Allergens declaration
    - could provide an Extracurricular activities schedule
    - Regular Users:
    - must provide a schedule
    - can change schedule at any time
    - Ticket Users:
    - must provide at least a date
    - can buy tickets at any time

    @buyingtickets
    Scenario: Student wants to buy a Cantine Ticket for First Time
        Given There is a Student called 'Pedro Pérez'
        And Student is not registered as Cantine User
        When Student buys a ticket to eat on date '11/14/2016'
        Then Student should be registered as Cantine User
        And Student should be assigned to a CantineGroup
        And A ticket for date '11/14/2016' should be registered
        And Student should be eating on date '11/14/2016'

    @buyingtickets
    Scenario: Student wants to buy a Cantine Ticket
        Given There is a Student called 'Eva López'
        And Student is registered as Cantine User
        When Student buys a ticket to eat on date '11/20/2016'
        Then Student should be eating on date '11/20/2016'
        And A ticket for date '11/20/2016' should be registered

    @buyingtickets
    Scenario: Student wants to buy a ticket for a previously scheduled date
        Given There is a Student called 'Martín Fernández'
        And Student is registered as Cantine User
        When Student buys a ticket to eat on date '11/15/2016' that he has scheduled
        Then Student should be eating on date '11/15/2016'
        But No ticket should be registered
        And A notification should be send

    @buyingtickets
    Scenario: Student wants to buy several Cantine Tickets
        Given There is a Student called 'Rebeca Moreno'
        And Student is registered as Cantine User
        When Student buys tickets to eat on dates
            | dates |
            | 11/21/2016 |
            | 11/22/2016 |
            | 11/23/2016 |
        Then Student should be eating on dates
            | dates |
            | 11/21/2016 |
            | 11/22/2016 |
            | 11/23/2016 |
        And tickets should be registered for dates
            | dates |
            | 11/21/2016 |
            | 11/22/2016 |
            | 11/23/2016 |

    @regularusers
    Scenario: Student wants to apply as Regular Cantine User for first time
        Given There is a Student called 'Fernando González'
        And Student is not registered as Cantine User
        When Student applies to Cantine with schedule
            | month | weekdays |
            | october | monday, tuesday |
            | november | monday, wednesday, friday |
        Then Student should be registered as Cantine User
        And Student should be assigned to a CantineGroup
        And Student should be eating on dates
            | dates |
            | 10/17/2016 |
            | 10/18/2016 |
            | 11/14/2016 |
            | 11/16/2016 |
            | 11/18/2016 |
        But Student should not be eating on dates
            | dates |
            | 10/19/2016 |
            | 11/15/2016 |

    @regularusers
    Scenario: Returning Student wants to modify its schedule
        Given There is a Student called 'Estrella Castro'
        And Student is registered as Cantine User with a schedule
            | month | weekdays |
            | october | monday, tuesday |
            | november | monday, wednesday, friday |
        When Student modifies its schedule with
            | month | weekdays |
            | january | monday, wednesday |
            | february | monday, wednesday, friday |
        Then Student should be eating on dates
            | dates |
            | 10/17/2016 |
            | 10/18/2016 |
            | 11/14/2016 |
            | 11/16/2016 |
            | 11/18/2016 |
            | 01/16/2017 |
            | 01/18/2017 |
            | 02/13/2017 |
            | 02/15/2017 |
            | 02/17/2017 |
        But Student should not be eating on dates
            | dates |
            | 10/19/2016 |
            | 11/15/2016 |
            | 01/17/2017 |
            | 02/14/2017 |
            | 02/16/2017 |
