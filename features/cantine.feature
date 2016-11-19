Feature: Students use the Cantine
    As a Student
    I want to apply to the Cantine Service or buy a ticket
    In order to use the Cantine Service on an schedule or on a specfic date
    Rules:
    - All Users
    - could provide an Allergens declaration
    - could provide an Extracurricular activities schedule
    - Regular Users:
    - must provide a schedule
    - can change schedule at any time
    - Ticket Users:
    - must provide at least a date
    - can buy tickets at any time

    Background:
        Given there is a CantineUserManager
        And there is a CantineUserRepository

    Scenario: Student wants to apply as Regular Cantine User for first time
        Given Student with StudentId 'student-01'
        And There is no CantineUser associated to StudentId 'student-01'
        When Student with StudentId 'student-01' applies to Cantine with schedule
            | month | weekdays |
            | october | monday, tuesday |
            | november | monday, wednesday, friday |
        Then Student with StudentId 'student-01' should be registered as Cantine User with schedule
            | month | weekdays |
            | october | monday, tuesday |
            | november | monday, wednesday, friday |
        And Student with StudentId 'student-01' should be eating on date '11/14/2016'

    Scenario: Returning Student wants to modify its schedule
        Given Student with StudentId 'student-02'
        And There is a CantineUser with StudentId 'student-02' and previous schedule
            | month | weekdays |
            | october | monday, tuesday |
            | november | monday, wednesday, friday |
        When Student with StudentId 'student-02' applies to Cantine with schedule
            | month | weekdays |
            | january | monday, wednesday |
            | february | monday, wednesday, friday |
        Then Student with StudentId 'student-02' should update its Cantine User schedule to
            | month | weekdays |
            | october | monday, tuesday |
            | november | monday, wednesday, friday |
            | january | monday, wednesday |
            | february | monday, wednesday, friday |
        And Student with StudentId 'student-02' should be eating on date '1/16/2017'

    Scenario: Student wants to buy a Cantine Ticket for First Time
        Given Student with StudentId 'student-03'
        And There is no CantineUser associated to StudentId 'student-03'
        When Student with StudentId 'student-03' buys a ticket to eat on date '11-14-2016'
        Then StudentId 'student-03' should be registered as Cantine User with scheduled date '11-14-2016'
        And Student with StudentId 'student-03' should be eating on date '11/14/2016'

    Scenario: Student wants to buy a Cantine Ticket
        Given Student with StudentId 'student-04'
        And There is a CantineUser with StudentId 'student-04' and has a prior ticket for date '11-15-2016'
        When Student with StudentId 'student-04' buys a ticket to eat on date '11-20-2016'
        Then Student with StudentId 'student-04' should update its Cantine User schedule to date '11-20-2016n'
        And Student with StudentId 'student-04' should be eating on dates
            | dates |
            | 11-15-2016 |
            | 11-20-2016 |
