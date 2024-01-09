USE mydatabase;

CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL

);
CREATE TABLE IF NOT EXISTS password_resets (
    email VARCHAR(100) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (email),
    UNIQUE KEY (token)
);
CREATE TABLE IF NOT EXISTS tickets (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  status ENUM('open', 'closed') NOT NULL DEFAULT 'open',
  priority ENUM('low', 'medium', 'high') NOT NULL DEFAULT 'low',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  user_id INT(11) UNSIGNED NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)

);
  -- Enable event scheduler
SET GLOBAL event_scheduler = ON;

-- Create event to delete expired tokens
CREATE EVENT IF NOT EXISTS delete_expired_tokens
ON SCHEDULE EVERY 2 MINUTE
ON COMPLETION PRESERVE
DO
  DELETE FROM password_resets WHERE created_at < DATE_SUB(NOW(), INTERVAL 2 MINUTE);

INSERT INTO users (name, email, password) 
VALUES ('John', 'admin@vantage.com', 'LinSelanSteOdynoRtstUm'),
       ('Jane', 'jane@vantage.com', 'IoNSTRadvary'),
       ('Bob', 'bob@vantage.com', 'DOWNERmOsPoRPrEi'),
       ('Karen', 'karen@vantage.com', 'FREshPa$$'),
       ('Mark', 'mark@vantage.com', 'pA$$word123'),
       ('Jenny', 'jenny@vantage.com', 'BlUeSk1e$!'),
       ('Mike', 'mike@vantage.com', 'H0peles$'),
       ('Lisa', 'lisa@vantage.com', 'tRu3L0ve!'),
       ('Sam', 'sam@vantage.com', 'pAssionate#'),
       ('Julie', 'julie@vantage.com', 'S3cur3d!'),
       ('Chris', 'chris@vantage.com', 'pR1v4te!'),
       ('Mary', 'mary@vantage.com', 'S3cretP@s$'),
       ('Kevin', 'kevin@vantage.com', '1mportant#'),
       ('Emily', 'emily@vantage.com', 'L0v3lyDay!'),
       ('Ben', 'ben@vantage.com', 'h0lygr41l'),
       ('Rachel', 'rachel@vantage.com', 'f0rg0tten#'),
       ('Steve', 'steve@vantage.com', 'cH@llenger#'),
       ('Megan', 'megan@vantage.com', 'sUp3rStar!'),
       ('Greg', 'greg@vantage.com', '3nigm@#'),
       ('Kim', 'kim@vantage.com', 'sUnFl0wer$'),
       ('Eric', 'eric@vantage.com', 'sUns3t$!'),
       ('Michelle', 'michelle@vantage.com', 'h4ppyD@y#'),
       ('Tom', 'tom@vantage.com', 'cH@rl13'),
       ('Samantha', 'samantha@vantage.com', 'f1rstL0ve!'),
       ('Matt', 'matt@vantage.com', 'sT@rdust#'),
       ('Olivia', 'olivia@vantage.com', 'cH0c0l@te$'),
       ('Peter', 'peter@vantage.com', 'pR3cious#'),
       ('Lauren', 'lauren@vantage.com', 'd@nc1ngqu33n'),
       ('Adam', 'adam@vantage.com', 'm@ch1n3ry#'),
       ('Kelly', 'kelly@vantage.com', 'bL@ckC@t$'),
       ('Jake', 'jake@vantage.com', 'sT@rryNight#');

INSERT INTO tickets (title, description, status, priority, user_id)
VALUES ('Website not loading', 'The website is not loading properly', 'open', 'high', 1),
       ('Incorrect billing amount', 'My billing amount is incorrect', 'open', 'medium', 1),
       ('Internal Server Name', 'Change name for Internal Backup server "backup-server.vantage"', 'open', 'medium', 1),
       ('Account Access', 'I cant access my account even after resetting password', 'closed', 'high', 1),
       ('Product not working', 'The product I purchased is not working as expected', 'open', 'medium', 1),
       ('Wrong product received', 'I received the wrong product in my order', 'closed', 'low', 1);       
