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

    Scenario: Student want to apply as RegularCantineUser for first time
        Given Student with StudentId 'student-01' which provides an schedule
            | month | weekdays |
            | october | monday, tuesday |
            | november | monday, wednesday, friday |
        And There is no RegularCantineUser associated
        When He applies to Cantine as RegularCantineUser
        Then A CantineUser with StudentId should be created
        And That CantineUser is added to CantineUsers Repository
