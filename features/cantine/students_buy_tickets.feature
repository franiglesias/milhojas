@buyingtickets
Feature: Students buy tickets for cantine
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

    Scenario: Student wants to buy a Cantine Ticket for First Time
        Given There is a Student called 'Pedro Pérez'
        And Student is not registered as Cantine User
        When Student buys a ticket to eat on date '11/14/2016'
        Then Student should be assigned to a CantineGroup
        And Student should be registered as Cantine User
        And A ticket for date '11/14/2016' should be registered
        And Student should be eating on date '11/14/2016'

    Scenario: Student wants to buy a Cantine Ticket
        Given There is a Student called 'Eva López'
        And Student is registered as Cantine User
        When Student buys a ticket to eat on date '11/20/2016'
        Then Student should be eating on date '11/20/2016'
        And A ticket for date '11/20/2016' should be registered

    Scenario: Student wants to buy a ticket for a previously scheduled date
        Given There is a Student called 'Martín Fernández'
        And Student is registered as Cantine User
        When Student buys a ticket to eat on date '11/15/2016' that he has scheduled
        Then Student should be eating on date '11/15/2016'
        But No ticket should be registered
        And A notification should be send

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
