Feature: Count tickets sold different periods
    As an admin
    I want to know how many tickets are sold every day
    In order to know how much income we should have

    Scenario: Getting tickets sold on a day
        Given We sold 30 tickets on a day
        And Every ticket costs 7.25€
        When We close the day
        Then Daily Income should be 217.5€

    Scenario: Getting tickets sold on a week
        Given This week we sold these tickets each day
            | weekday | tickets |
            | monday | 20 |
            | tuesday | 23 |
            | wednesday | 15 |
            | thursday | 16 |
            | friday | 12 |
        And Every ticket costs 7.25€
        When We close the week
        Then Weekly Income should be 623.5€
        And Total tickets sold should be 86
