Feature: Get the list of today's cantine users
    As a Admin
    I want to get the list of users that will be eating today
    In order to prepare the meals

    Scenario: Admin wants to get the list of taday's users
        Given There are some Cantine Users registered
            | student_id | group | type | schedule |
            | student-01 | Grupo 1 | regular | november: monday, wednesday |
            | student-02 | Grupo 2 | ticket | 11/14/2016 |
            | student-03 | Grupo 3 | regular | november: tuesday, friday |
            | student-04 | Grupo 4 | ticket | 11/25/2016 |
        And turns are the following
            | Turno 1 |
            | Turno 2 |
            | Turno 3 |
        And groups are the following
            | Grupo 1 |
            | Grupo 2 |
            | Grupo 3 |
            | Grupo 4 |
        And Rules for turn assignation are
            | rule | schedule | group | turn |
            | Grupo 1 eats on turn 1 all days | monday, tuesday, wednesday, thursday, friday | Grupo 1 | Turno 1 |
            | Grupo 2 eats on turn 2 Mon and Wed | monday, wednesday | Grupo 2 | Turno 2 |
            | Grupo 2 eats on turn 3 Tue, Thu, Fri | tuesday, thursday, friday | Grupo 2 | Turno 3 |
        And Today is '11/14/2016'
        When Admin asks for the list
        Then the list should contain this Cantine Users
            | student-01 |
            | student-02 |
        But the list should not contain this Cantine Users
            | student-03 |
            | student-04 |
        And the turns should be assigned as
            | student_id | turn |
            | student-01 | Turno 1 |
            | student-02 | Turno 2 |
