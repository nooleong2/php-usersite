-- 전체 데이터베이스 보기
SHOW DATABASES;

-- 데이터베이스 사용
USE world;

-- 전체 테이블 보기
SHOW TABLES;

-- 테이블 정보 조회
SHOW TABLE STATUS;

-- 테이블에 무슨 열이 있는지 확인
DESC city;

-- Quiz) country 테이블과 countrylanguage 테이블 정보 조회
DESC country;
DESC countrylanguage;




-- SELECT
-- 요구하는 데이터를 가져오는 구문
-- 일반적으로 가장 많이 사용되는 구문
-- 데이터베이스 내 테이블에서 원하는 정보를 추출
-- ex SELECT * FROM [테이블 이름];
-- city 테이블에 있는 전체 데이터 출력
SELECT * FROM city;

-- city 테이블에 있는 해당 column 컬럼만 출력
SELECT name, countrycode FROM city;

-- SELECT (WHERE)
-- 조회하는 결과에 특정한 조건으로 원하는 데이터만 보고 싶을 때 사용
-- 조건이 없을 경우 테이블의 크기가 클수록 찾는 시간 증가
-- SELECT [컬럼 이름] FROM [테이블 이름] WHERE [조건식];
SELECT name, population FROM city WHERE countrycode = "KOR";
SELECT * FROM city WHERE population >= 8000000;
SELECT * FROM city WHERE population <= 8000000;

-- SELECT (연산자)
-- AND, OR, 
-- 조건 연산자 [=, <, >, <=, >=, <>, != 등...]
-- 관계 연산자 [NOT, AND, OR 등]
-- 연산자의 조합으로 데이터를 효율적으로 추출
-- population이 8백만 이하 7백만 이상의 데이터만 출력
SELECT * FROM city WHERE population <= 8000000 AND population >= 7000000;

-- Quiz) 한국에 있는 도시들 보기
SELECT * FROM city WHERE countrycode = "KOR";

-- Quiz) 미국에 있는 도시들 보기
SELECT * FROM city WHERE countrycode = "USA";

-- Quiz) 한국에 있는 도시들 중에 인구 수가 1,000,000 이상인 도시 보기
SELECT * FROM city WHERE population >= 1000000 AND countrycode = "KOR";

-- SELECT (BETWEEN)
-- 데이터가 숫자로 구성되어 있어 연속적인 값은 BETWEEN ... AND 사용 가능
-- population이 7백만 이하 8백만 이상의 데이터만 출력 (위에 <=, >=) 조건 연산자랑 동일
SELECT * FROM city WHERE population BETWEEN 7000000 AND 8000000;

-- SELECT (IN)
-- 이산적인 값의 조건에서는 IN() 사용 가능
-- 내가 정한 값만 보고 싶을 때 사용
-- 서울, 뉴욕, 도쿄의 데이터만 출력
SELECT * FROM city WHERE name IN("SEOUL", "NEW YORK", "TOKYO");

-- Quiz) 한국, 미국, 일본 도시들 보기
SELECT * FROM city WHERE countrycode IN("KOR", "NEW YORK", "JPN");

-- SELECT (LIKE)
-- 문자열의 내용 검색하기 위해 LIKE 연산자 사용
-- 문자 뒤에 %-무엇이든(%) 허용
-- 한 글자와 매치하기 위해서는 '_' 사용
SELECT * FROM city WHERE countrycode LIKE "K_R";
SELECT * FROM city WHERE countrycode LIKE "_OR";
SELECT * FROM city WHERE countrycode LIKE "KO_";

-- 뒤에 글자가 아무것도 생각이 안날때 해당 문자열을 포함한 모든 데이터 출력
SELECT * FROM city WHERE name LIKE "TEL%";

-- SELECT (SUB QUERY)
-- 쿼리문 안에 또 쿼리문이 들어 있는 것
-- 서브 쿼리의 결과가 둘 이상이 되면 에러 발생
-- 러시아 도시 데이터를 출력할건데 러시아 countrycode는 모르지만 러시아 도시 이름으로 러시아 countrycode 찾아서 출력
SELECT * FROM city WHERE countrycode = (
													SELECT countrycode FROM city WHERE name = "MOSCOW"
);

-- SELECT (SUB QUERY ANY, ALL)
-- ANY : 서브쿼리의 여러 개의 결과 중 한 가지만 만족해도 가능
-- ALL : 서브쿼리의 여러 개의 결과를 모두 만족 시켜야 함
-- SOME == ANY 동일한 의미
-- = ANY 구문은 IN과 동일한 의미
-- 뉴욕 구역을 가지고 있는 도시의 population 보다 큰 도시 다 출력
SELECT * FROM city WHERE population > ANY (
													SELECT population FROM city WHERE district = "NEW YORK"
);

-- 뉴욕 구역을 가지고 있는 도시의 population 중 가장 큰 값 보다 더 큰 값 도시들만 출력
SELECT * FROM city WHERE population > ALL (
													SELECT population FROM city WHERE district = "NEW YORK"
);

-- SELECT (ORDER BY)
-- 결과가 출력되는 순서를 조절하는 구문
-- 기본적으로 오름차순(ASCENDING) 정렬
-- 내림차순(DECENDING) 정렬 || 열 이름 뒤에 DESC 적어줄 것
-- ASC(오름차순)의 경우 DEFAULT 이므로 생략 가능
-- 혼합해서 사용 가능
-- city 데이터 중에 population 기준으로 내림차순 출력 
SELECT * FROM city ORDER BY population DESC;
-- city 데이터 중에 population 기준으로 오름차순 출력 (ASC) 생략 가능
SELECT * FROM city ORDER BY population;
-- countrycode 는 오름차순, population은 내림차순 정렬로 출력
SELECT * FROM city ORDER BY countrycode ASC, population DESC;

-- Quiz) 인구수로 내림차순하여 한국에 있는 도시 보기
SELECT * FROM city WHERE countrycode = "KOR" ORDER BY population DESC;
-- Quiz) 국가 면적 크기(surfacearea)로 내림차순하여 나라 보기(country table)
SELECT * FROM country ORDER BY surfacearea DESC;

-- SELECT (DISTINCT)
-- 중복된 것은 1개씩만 보여주면서 출력
-- 테이블의 크기가 클수록 효율적
-- countrycode 를 중복 없이 보여줘
SELECT DISTINCT(countrycode) FROM city;

-- SELECT (LIMIT)
-- 출력 개수를 제한
-- 상위의 N개만 출력하는 'LIMIT N' 구문
-- 서버의 처리량을 많이 사용해서 서버의 전반적인 성능을 나쁘게 하는 악성 쿼리문 개선할 때 사용
-- 인구수 내림차순으로 정렬하고 상위 5개의 도시만 출력
SELECT * FROM city ORDER BY population DESC LIMIT 5;

-- SELECT (GROUP BY)
-- 그룹으로 묶어주는 역할
-- 집계 함수를 함께 사용
-- AVG() : 평균
-- MIN() : 최소값
-- MAX() : 최대값
-- COUNT() : 행의 개수
-- COUNT(DISTINCT) : 중복 제외된 행의 개수
-- STDEV() : 표준 편차
-- VARIANCE() : 분산
-- 효율적인 데이터 그룹화
-- 읽기 좋게 하기 위해 별칭 (ALIAS) 사용
-- countrycode를 그룹화 시키고countrycode, population을 최대값만 출력
SELECT countrycode, MAX(population) FROM city GROUP BY countrycode;

-- Quiz) 도시는 몇개인가?
SELECT COUNT(*) FROM city;
-- Quiz) 도시들의 평균 인구수는?
SELECT AVG(population) FROM city GROUP BY district;

-- SELECT (HAVING)
-- WHERE과 비슷한 개념으로 조건 제한
-- 집계 함수에 대해서 조건 제한하는 편리한 개념
-- HAVING절은 반드시 GROUP BY절 다음에 사용
-- countrycode를 그룹화 하고 population이 가장 큰것만 보여주는 대신에 8,000,000만 이상만 출력
SELECT countrycode, MAX(population) FROM city GROUP BY countrycode HAVING MAX(population) > 8000000;

-- SELECT (ROLL UP)
-- 총 합 또는 중간합계가 필요할 경우 사용
-- GROUP BY절과 함께 WITH ROLL UP문 사용
-- population의 총합 출력
SELECT countrycode, name, SUM(population) FROM city GROUP BY countrycode, name WITH ROLLUP;

-- SELECT (JOIN)
-- 데이터베이스 내의 여러 테이블에서 가져온 레코드를 조합하여 하나의 테이블이나 결과 집합으로 표현
-- city 테이블과 country 테이블을 조인해줘 (조건 : countrycode 기준)
SELECT * FROM city JOIN country ON city.countrycode = country.code;

-- Quiz) city, country, countrylanguage 테이블 3개를 JOIN
SELECT * FROM city a
JOIN country b ON a.countrycode = b.code
JOIN countrylanguage c ON a.countrycode = c.countrycode WHERE a.countrycode = "KOR";

-- 내장 함수
-- 사용자의 편의를 위해 다영한 기능의 내장 함수를 미리 정의하여 제공
-- 대표적인 내장 함수의 종류
-- 문자열 함수
-- 수학 함수
-- 날찌와 시간 함수

-- LENGTH
-- 전달받은 문자열의 길이를 반환
SELECT LENGTH("total count");

-- CONCAT
-- 전달받은 문자열을 모두 결합하여 하나의 문자열로 반환
-- 전달받은 문자열 중 하나라도 NULL이 존재하면 NULL을 반환
SELECT CONCAT("My", "sql Op", "en Source");

-- LOCATE
-- 문자열 내에서 찾는 문자열이 처음으로 나타나는 위치를 찾아서 해당 위치를 반환
-- 찾는 문자열이 문자열 내에 존재하지 않으면 0을 반환
-- MySQL에서는 문자열의 시작 인덱스를 1부터 계산
SELECT LOCATE("hello", "My Name is YellowDog Hello Nice to meet you");

-- LEFT, RIGHT
-- 사작 인덱스를 1부터 계산
-- LEFT : 문자열의 왼쪽부터 지정한 개수만큼 문자를 반환
-- RIGHT : 문자열의 오른쪽부터 지정한 개수만큼의 문자를 반환
SELECT
LEFT("MySQL is an open source relational database management system", 5),
RIGHT("MySQL is an open source relational database management system", 6);

-- LOWER, UPPER
-- LOWER : 문자열의 문자를 모두 소문자로 변경
-- UPPER : 문자열의 문자를 모두 대문자로 변경
SELECT
LOWER("MySQL Is An Open Source Relational Database Management System"),
UPPER("MySQL is an open source relational database management system");

-- REPLACE
-- 문자열에서 특정 문자열을 대체 문자열로 교체
SELECT REPLACE("MYSQL", "MY", "MS");

-- TRIM
-- 문자열의 앞이나 뒤, 또는 양쪽 모두에 있는 특정 문자를 제거
-- TRIM : 함수에서 사용할 수 있는 지정자
-- BOTH : 전달받은 문자열의 양 끝에 존재하는 특정 문자를 제거(기본 설정)
-- LEADING : 전달받은 문자열 앞에 존재하는 특정 문자를 제거
-- TRAILING: 전달받은 문자열 뒤에 존재하는 특정 문자를 제거
-- 만약 지정자를 명시하지 않으면, 자동으로 BOTH로 설정
-- 제거할 문자를 명시하지 않으면, 자동으로 공백 제거
SELECT
TRIM("          ##MYSQL##            "),
TRIM(LEADING "#" FROM "##MYSQL##"),
TRIM(TRAILING "#" FROM "##MYSQL##");

-- FORMAT
-- 숫자 타입의 데이터를 세 자리마다 쉼표(,)를 사용하는 "#,###,###.##" 형슥으로 변환
-- 반환되는 데이터의 형식은 문자열 타입
-- 두 번째 인수는 반올림할 소수 부분의 자릿수
SELECT FORMAT(12345678.9876543, 3);

-- FLOOR, CEIL, ROUND
-- FLOOR : 내림
-- CEIL : 올림
-- ROUND : 반올림
SELECT FLOOR(10.95), CEIL(10.95), ROUND(10.95);

-- SQRT, POW, EXP, LOG
-- SQRT : 양의 제곱근
-- POW : 첫 번쨰 인수로는 밑수를 전달하고, 두 번째 인수로는 지수를 전달하여 거듭제곱 계산
-- EXP : 인수로 지수를 전달받아, e의 거듭 제곱을 계산
-- LOG : 자연로그 값을 계산
SELECT SQRT(4), POW(2, 3), EXP(3),  LOG(3);

-- SIN, COS, TAN
-- SIN : 사인 값 반환
-- COS : 코사인 값 반환
-- TAN : 탄젠트 값 반환
SELECT SIN(PI() / 2), COS(PI()), TAN(PI() / 4);

-- ABS, RAND()
-- ABS : 절대 값 반환
-- RAND : 0.0보다 크거나 같고 1.0보다 작은 하나의 실수를 무작위로 생성
SELECT ABS(-3), RAND(), ROUND(RAND() * 100, 0);

-- NOW, CURDATE, CURTIME
-- NOW : 현재 날짜와 시간을 반환, 반환되는 값은 "YYYY-MM-DD HH:MM:SS" 또는 "YYYYMMDDHHMMSS" 형태로 반환
-- CURDATE : 현재 날짜를 반환, 이 때 반환 되는 값은 "YYYY-MM-DD" 또는 "YYYYMMDD" 형태로 반환
-- CURTIME : 현재 시간을 반환, 이 때 반환 되는 값은 "HH:MM:SS" 또는 "HHMMSS" 형태로 반환
SELECT NOW(), CURDATE(), CURTIME();

-- DATE, MONTH, DAY, HOUR, MINUTE, SECOND
-- DATE : 전달받은 값에 해당하는 날짜 정보를 반환
-- MONTH : 월에 해당하는 값을 반환하며, 0 ~ 12 사이의 값을 가짐
-- DAY : 일에 해당하는 값을 반환하며, 0 ~ 31 사이의 값을 가짐
-- HOUR : 시간에 해당하는 값을 반환하며, 0 ~ 23 사이의 값을 가짐
-- MINUTE : 분에 해당하는 값을 반환하며, 0 ~ 59 사이의 값을 가짐
-- SECOND : 초에 해당하는 값을 반환하며, 0 ~ 59 사이의 값을 가짐
SELECT
NOW(),
DATE(NOW()),
MONTH(NOW()),
DAY(NOW()),
HOUR(NOW()),
MINUTE(NOW()),
SECOND(NOW());

-- MONTHNAME, DAYNAME
-- MONTHNAME : 월에 해당하는 이름을 반환
-- DAYNAME : 요일에 해당하는 이름을 반환
SELECT
MONTHNAME(NOW()),
DAYNAME(NOW());

-- DAYOFWEEK, DAYOFMONTH, DAYOFYEAR
-- DAYOFWEEK : 일자가 해당 주에서 몇번째 날인지를 반환, 1 ~ 7 사이의 값을 반환 (일요일 = 1, 토요일 = 7)
-- DAYOFMONTH : 일자가 해당 월에서 몇 번째 날인지를 반환, 0 ~ 31 사이의 값을 반환
-- DAYOFYEAR : 일자가 해당하는 연도에서 몇번째 날인지를 반환, 1 ~ 366 사이의 값을 반환
SELECT
DAYOFWEEK(NOW()),
DAYOFMONTH(NOW()),
DAYOFYEAR(NOW());

-- DATE_FORMAT
-- 전달받은 형식에 맞춰 날짜와 시간 정보를 문자열로 반환
SELECT DATE_FORMAT(NOW(), "%D %y %a %d %n %j");


-- CREATE TABLE AS SELECT
-- city 테이블과 똑같은 city2테이블 생성
CREATE TABLE city2 AS SELECT * FROM city;

-- CREATE DATABASE
-- CREATE DATABASE 문은 새로운 데이터베이스를 생성
-- USE문으로 새 데이터베이스를 사용
CREATE DATABASE sample;

-- CREATE TABLE
CREATE TABLE test2 (
	id INT NOT NULL PRIMARY KEY,
    col1 INT NULL,
    col2 FLOAT NULL,
    col3 VARCHAR(45) NULL
);

SELECT * FROM test2;
DESC test2;

-- ALTER TABLE
-- ADD 문을 사용하면 테이블에 컬럼을 추가 가능
ALTER TABLE test2 ADD col4 INT NULL;

-- MODIFY 문을 사용하면 테이블의 컬럼 타입을 변경 가능
ALTER TABLE test2 MODIFY col4 VARCHAR(20) NULL;

-- DROP 문을 사용하면 테이블에 컬럼을 제거할 수 있음
ALTER TABLE test2 DROP col4;

-- INDEX
-- 테이블에서 원하는 데이터를 빠르게 찾기 위해 사용
-- 일반적으로 데이터를 검색할 때 순서대로 테이블 전체를 검색하므로 데이터가 많으면 많을수록 탐색하는 시간이 늘어난다.
-- 검색과 질의를 할 때 테이블 전체를 읽지 않기 때문에 빠르다.
-- 설정된 컬럼 값을 포함한 데이터의 삽입, 삭제, 수정 작업이 원본 테이블에서 이루어질 경우, 인덱스도 함께 수정되어야 한다.
-- 인덱스가 있는 테이블은 처리 속도가 느려질 수 있으므로 수정보다는 검색이 자주 사용되는 테이블에서 사용하는 것이 좋다.

-- CREATE INDEX
-- 인덱스 생성
CREATE INDEX Col1Idx ON test (col1);

-- SHOW INDEX
-- 인덱스 정보 보기
SHOW INDEX FROM test;

-- CREATE UNIQUE INDEX
-- 중복 값을 허용하지 않는 인덱스
CREATE UNIQUE INDEX Col2Idx ON test (col2);

-- FULLTEXT INDEX
-- 일반적인 인덱스와는 달리 매우 빠르게 테이블의 모든 텍스트 컬럼을 검색
ALTER TABLE test ADD FULLTEXT Col3Idx (col3);

-- INDEX DELETE (ALTER)
-- ALTER 문을 사용하여 테이블에 추가된 인덱스 삭제
ALTER TABLE test DROP INDEX Col3Idx;

-- INDEX DELETE (DROP INDEX)
-- DROP 문을 사용하여 해당 테이블에서 명시된 인덱스를 삭제
-- DROP 문은 내부적으로 ALTER 문으로 자동 변환되어 명시된 이름의 인덱스를 삭제
DROP INDEX Col2Idx ON test;

-- VIEW
-- 데이터베이스에 존재하는 일종의 가상 테이블
-- 실제 테이블처럼 행과 열을 가지고 있지만, 실제로 데이터를 저장하진 않음
-- MySQL에서 VIEW는 다른 테이블이나 다른 VIEW에 저장되어 있는 데이터를 보여주는 역할만 수행
-- VIEW를 사용하면 여러 테이블이나 VIEW를 하나의 테이블처럼 볼 수 있음

-- VIEW 장점
-- 특정 사용자에게 테이블 전체가 아닌 필요한 컬럼만 보여줄 수 있음
-- 복잡한 쿼리를 단순화해서 사용
-- 쿼리 재사용 가능
-- VIEW 단점
-- 한 번 정의된 뷰는 변경할 수 없음
-- 삽입, 삭제, 갱신 작업에 많은 제한 사항을 가짐
-- 자신만의 인덱스를 가질 수 없음

-- CREATE VIEW
-- VIEW 보기
SELECT * FROM testView;

-- VIEW 생성
CREATE VIEW testView AS SELECT Col1, Col2 FROM test;

-- VIEW 수정
ALTER VIEW testView AS SELECT Col1, Col2, Col3 FROM test;

-- VIEW 삭제
DROP VIEW testView;

-- Quiz) city, country, countrylanguage 테이블을 JOIN하고, 한국에 대한 정보만 뷰 생성하기
CREATE VIEW allView AS SELECT a.name, b.surfacearea, a.population, c.language FROM city AS a
JOIN country AS b ON a.countrycode = b.code
JOIN countrylanguage AS c ON b.code = c.countrycode WHERE a.countrycode = "KOR";

SELECT * FROM allView;

-- INSERT
-- 테이블 이름 다음에 나오는 열 생략 가능
-- 생략할 경우에 VALUE 다음에 나오는 값들의 순서 및 개수가 테이블이 정의된 열 순서 및 개수와 동일해야 된다.
INSERT INTO test VALUES (1, 123, 1.1, "TEST");
INSERT INTO test VALUES (2, 234, 2.2, "TEST");
INSERT INTO test VALUES (3, 345, 3.3, "TEST");

-- INSERT INTO SELECT
-- 원하는테이블에 있는 데이터를 새로운 테이블에 삽입
INSERT INTO test2 SELECT * FROM test;

-- UPDATE
-- 기존에 입력되어 있는 값 변경하는 구문
-- WHERE절 생략 가능하나 테이블의 전체 행의 내용 변경
-- 주의) WHERE절 을 꼭 사용해서 바꿀려고 하는 데이터만 바꿔야 한다.
UPDATE test SET col1 = 1, col2 = 1.0, col3 = "test" WHERE id = 1;

-- DELETE
-- 행 단위로 데이터 삭제하는 구문
-- 데이터는 지워지지만 테이블 용령은 줄어들지 않는다.
-- 원하는 데이터만 지우기 가능
-- 삭제 후 잘못 삭제한 것을 되돌리기 가능
-- 주의) WHERE절 을 꼭 사용해서 바꿀려고 하는 데이터만 바꿔야 한다.
DELETE FROM test WHERE id = 1;

-- TRUNCATE
-- 용량이 줄어 들고, 인덱스 등도 모두 삭제
-- 테이블은 삭제하지는 않고, 데이터만 삭제
-- 한꺼번에 다 지워야 한다.
-- 삭제 후 절대 되돌릴 불가능
TRUNCATE TABLE test;

-- DROP TABLE
-- 테이블 전체를 삭제, 공간, 객체를 삭제
-- 삭제 후 절대 되돌리기 불가능
DROP TABLE test;


-- DROP DATABASE
-- 해당 테이터베이스를 삭제
DROP DATABASE sample;

-- Quiz) 자신만의 연락처 테이블 만들기 (이름, 전화번호, 주소, 이메일)
-- 1. 데티어베이스 생성
CREATE DATABASE myInfo;

-- 2. 데이터베이스 사용
USE myInfo;

-- 3. 테이블 생성
CREATE TABLE info (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(10) NOT NULL,
    phone CHAR(13) NOT NULL,
    address VARCHAR(255) NULL,
    email VARCHAR(50) NOT NULL
);

-- 4. 테이블 보기
SELECT * FROM info;

-- 5. 데이터 삽입
INSERT INTO info (name, phone, address, email) VALUES ("누러잉", "010-1234-5678", "서울 강남구", "nooleong2@fake.com");

-- 6. 데이터 수정
UPDATE info SET phone = "010-2222-3333" WHERE id = 1;

-- 7. 데이터 삭제
DELETE FROM info WHERE id = 1;

-- 8. 테이블 삭제
DROP TABLE info;

-- 9. 데이터베이스 삭제
DROP DATABASE myinfo;














