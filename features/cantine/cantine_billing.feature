Feature: Cantine regular users billing
    As an Admin
    I want to be able to count monthly cantine Users
    in order to Billing them

    Scenario: Month with several users
        Given There are some regular users
            | student_id | group | type | schedule |
            | student-01 | Grupo 1 | regular | november: monday, wednesday, friday |
            | student-02 | Grupo 2 | ticket | 11/14/2016 |
            | student-03 | Grupo 3 | regular | november: tuesday, friday |
            | student-04 | Grupo 4 | ticket | 11/25/2016 |
            | student-05 | Grupo 3 | regular | october: tuesday, friday |
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
            | student-01 | 3 | 60 |
            | student-03 | 2 | 50 |
