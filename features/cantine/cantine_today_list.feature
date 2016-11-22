Feature: Get the list of today's cantine users
    As a Admin
    I want to get the list of users that will be eating today
    In order to prepare the servings

    Scenario: Admin wants to get the list of taday's users
        Given There are some Cantine Users registered
            | student_id | type | schedule |
            | student-01 | regular | november: monday, wednesday |
            | student-02 | ticket | 11/14/2016 |
            | student-03 | regular | november: tuesday, friday |
            | student-04 | ticket | 11/25/2016 |
        And Today is '11/14/2011'
        When Admin asks for the list
        Then the list should contain this Cantine Users
            | student_id |
            | student-01 |
            | student-02 |
