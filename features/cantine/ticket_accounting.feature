Feature: Count tickets sold different periods
    As an admin
    I want to know how many tickets are sold every day
    In order to know how much income we should have

    Background:
        Given We have tickets registered
            | user | date |
            | student-01 | 11/16/2016 |
            | student-02 | 11/16/2016 |
            | student-01 | 11/17/2016 |
            | student-02 | 11/17/2016 |
            | student-03 | 11/17/2016 |
            | student-04 | 12/15/2016 |
            | student-01 | 12/16/2016 |
        And Every ticket costs '7.25' €

    Scenario: Getting tickets sold on a day
        When We count items for date '11/17/2016'
        Then Total tickets sold should be '3'
        And Total income should be '21.75' €

    Scenario: Getting tickets sold on a month
        When We account tickets for month 'november 2016'
        Then Total tickets sold should be '5'
        And Total income should be '36.25' €
