Feature: Students use the Cantine
    As a Student
    I want to apply to the Cantine Service or buy a ticket
    In order to use the Cantine Service on an schedule or on specfic dates
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

    Scenario: Student wants to apply as Regular Cantine User for first time
        Given Student with StudentId 'student-01'
        And There is no CantineUser associated to it
        When Student applies to Cantine with schedule
            | month | weekdays |
            | october | monday, tuesday |
            | november | monday, wednesday, friday |
        Then Student should be registered as Cantine User
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

    Scenario: Returning Student wants to modify its schedule
        Given Student with StudentId 'student-02'
        And There is a CantineUser associated and previous schedule
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

    Scenario: Student wants to buy a Cantine Ticket for First Time
        Given Student with StudentId 'student-03'
        And There is no CantineUser associated to it
        When Student buys a ticket to eat on date '11/14/2016'
        Then Student should be registered as Cantine User with scheduled date '11-14-2016'
        And Student should be eating on date '11/14/2016'

    Scenario: Student wants to buy a Cantine Ticket
        Given Student with StudentId 'student-04'
        And There is a CantineUser associated and has a prior ticket for date '11-15-2016'
        When Student buys a ticket to eat on date '11-20-2016'
        Then Student should update its Cantine User schedule to date '11-20-2016n'
        And Student should be eating on dates
            | dates |
            | 11-15-2016 |
            | 11-20-2016 |
