Feature: Get the list of today's cantine users
    As a Admin
    I want to get the list of users that will be eating today
    In order to prepare the meals

    Scenario: Admin wants to get the list of taday's users
        Given There are some Cantine Users registered
            | student_id | group | type | schedule |
            | student-01 | Group 1 | regular | november: monday, wednesday |
            | student-02 | Group 2 | ticket | 11/14/2016 |
            | student-03 | Group 3 | regular | november: tuesday, friday |
            | student-04 | Group 4 | ticket | 11/25/2016 |
        And turns are the following
            | Turno 1 |
            | Turno 2 |
            | Turno 3 |
        And Rules for turn assignation are
            | rule | schedule | group | turn |
            | Group 1 eats on turn 1 all days | monday, tuesday, wednesday, thursday, friday | Group 1 | 1 |
            | Group 2 eats on turn 2 Mon and Wed | monday, wednesday | Group 2 | 2 |
            | Group 2 eats on turn 3 Tue, Thu, Fri | tuesday, thursday, friday | Group 2 | 3 |
        And Today is '11/14/2016'
        When Admin asks for the list
        Then the list should contain this Cantine Users
            | student_id |
            | student-01 |
            | student-02 |
        But the list should not contain this Cantine Users
            | student_id |
            | student-03 |
            | student-04 |
        And the turns should be assigned as
            | student_id | turn |
            | student-01 | 1 |
            | student-02 | 2 |
