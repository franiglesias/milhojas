Feature: Students apply to Cantine
    All students should be able to apply to Cantine at any time during their school life
    They can do it as RegularUsers or Ticket Users
    Rules:
    - All Users
    - could provide an Allergens declaration
    - could provide an Extracurricular activities schedule
    - Regular Users:
    - must provide a schedule
    - can change schedule at any time
    - Ticket Users:
    - must provide at least a date
    - can add dates at any time

    Background:
        Given there is a CantineUserManager

    Scenario: Student wants to apply as RegularCantineUser for first time
        Given Student with StudentId 'student-01' which provides an schedule
            | month | weekdays |
            | october | monday, tuesday |
            | november | monday, wednesday, friday |
        And There is no RegularCantineUser associated
        When He applies to Cantine as RegularCantineUser
        Then A CantineUser with StudentId 'student-01' and schedule should be created
        And That CantineUser is added to CantineUsers Repository
        And RegularCantineUserWasCreated event will be raised by CantineUserManager

    Scenario: Returning Student wants to apply as RegularCantineUser
        Given Student with StudentId 'student-01' which provides a new schedule
            | month | weekdays |
            | january | monday, wednesday |
            | february | monday, wednesday, friday |
        And there is a RegularCantineUser with StudentId 'student-01' and schedule
            | month | weekdays |
            | october | monday, tuesday |
            | november | monday, wednesday, friday |
        When Student with StudentId 'student-01' applies to Cantine as RegularCantineUser
        Then CantineUser with StudentId 'student-01' will update schedule to
            | month | weekdays |
            | october | monday, tuesday |
            | november | monday, wednesday, friday |
            | january | monday, wednesday |
            | february | monday, wednesday, friday |
        And RegularCantineUserUpdatedScheduled event will be raised by CantineUserManager

    Scenario: Student wants to apply as TicketCantineUser for first time
        Given Student with StudentId 'student-01' wants to eat on '11-15-2016'
        And There is no CantineUser associated
        When Student with StudentId 'student-01' applies to Cantine as TicketCantineUser
        Then A TicketCantineUser with StudentId 'student-01' and schedule should be created
        And That TicketCantineUser is added to CantineUsers Repository
        And TicketCantineUserWasCreated event will be raised by CantineUserManager
