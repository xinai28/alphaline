# Exam Instructions

## Setup Steps
1. Fork the repository to your GitHub account and clone your fork
   ```bash
   git fork https://github.com/Cardinal-Alpha-Malaysia/ca_exam_question.git
   git clone [your-fork-url]
   cd [repository-name]
   ```

   When you have completed all questions, open a Pull Request to submit your work.

2. Install required dependencies
   ```bash
   composer install
   npm install
   ```

3. Set up your environment
    - Copy the `.env.example` file to `.env`
    - Configure your database settings in the `.env` file
    - Generate an application key: `php artisan key:generate`

4. Prepare the database
   ```bash
   php artisan migrate
   ```


## Overview
This exam requires you to implement a series of operations involving API interactions, data management, and financial calculations.

## Tasks

### 1. Study [the documents](https://exam.cardinalalpha.com/)

### 2. Perform the following:
#### 2a. Data Collection and Storage
- Pull Investor Data from the API endpoint
- Pull Fund Data from the API endpoint
- Pull Investor Investment Data from the API endpoint
- Save all retrieved data to your database

#### 2b. Data Update and Submission
- Create a form enable user to create a new investor record, and push the new investor info [here](https://exam.cardinalalpha.com/api/investor)
- Create a form enable user to update an existing investor, and push the updated data back to [here](https://exam.cardinalalpha.com/api/investor/{id})

### 3. Draw an Equity Curve
- Using the data in {file}, generate an equity curve visualization
- The equity curve should clearly display the performance over time
- Include appropriate labels and legends for clarity

### 4. Calculate Financial Metrics

#### 4a. Annual Return
Calculate the annual return based on the following formula:
```
Annual Return = mean of Pnl x 365
```

#### 4b. Sharpe Ratio
Calculate the Sharpe Ratio based on the following formula:
```
Sharpe Ratio = (mean of pnl / standard deviation of pnl) x square root of 365
```

#### 4c. Maximum Drawdown
Calculate the Maximum Drawdown based on the following formula:
```
Maximum Drawdown = Max of DD
```

#### 4d. Calmar Ratio
Calculate the Calmar Ratio based on the following formula:
```
Calmar Ratio = Annual Return / |Maximum Drawdown|
```
