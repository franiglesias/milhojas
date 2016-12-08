Feature: Count tickets sold different periods
    As an admin
    I want to know how many tickets are sold every day
    In order to know how much income we should have

    Background:
        Given We have tickets registered
            | user | date | paid |
            | student-01 | 11/16/2016 | yes |
            | student-02 | 11/16/2016 | no |
            | student-01 | 11/17/2016 | yes |
            | student-02 | 11/17/2016 | no |
            | student-03 | 11/17/2016 | yes |
            | student-04 | 12/15/2016 | yes |
            | student-01 | 12/16/2016 | no |
        And Every ticket costs '7.25' €

    Scenario: Getting tickets sold on a day
        When We count items for date '11/17/2016'
        Then Total tickets sold should be '3'
        And Total income should be '21.75' €
        And Pending tickets should be '1'
        And Pending income should be '7.25' €
        And Paid tickets should be '2'
        And Paid income should be '14.50' €

    Scenario: Getting tickets sold on a month
        When We account tickets for month 'november 2016'
        Then Total tickets sold should be '5'
        And Total income should be '36.25' €
        And Pending tickets should be '2'
        And Pending income should be '14.50' €
        And Paid tickets should be '3'
        And Paid income should be '21.75' €
