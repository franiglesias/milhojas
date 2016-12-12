Feature: Cantine regular users billing
    As an Admin
    I want to be able to count monthly cantine Users
    in order to Billing them

    Scenario: Month with several users
        Given There are some regular users
            | name | surname | gender | class | student_id | group | type | schedule |
            | Pedro | Pérez | m | EP 3 C | student-01 | Grupo 1 | regular | november: monday, wednesday |
            | Eva | Fernández | f | EP 5 A | student-02 | Grupo 2 | ticket | 11/14/2016 |
            | Luis | Rodríguez | m | ESO 1 A | student-03 | Grupo 3 | regular | november: tuesday, friday |
            | Isabel | López | f | ESO 4 B | student-04 | Grupo 4 | ticket | 11/25/2016 |
            | Enrique | Sánchez | m | EP 4 A | student-05 | Grupo 1 | regular | november: monday, friday |
            | Gabriela | Martínez | f | EP 4 B | student-06 | Grupo 1 | ticket | 11/14/2016 |
        And prices are the following
            | days | price |
            | 1 | 40 |
            | 2 | 50 |
            | 3 | 60 |
            | 4 | 70 |
            | 5 | 80 |
        When I generate bills for month 'November 2016'
        Then I should get a list of users like this
            | student | days | amount |
            | Pérez, Pedro | 3 | 60 |
            | Rodríguez, Luis | 2 | 50 |
            | Sánchez, Enrique | 2 | 50 |
