DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `total_amount` (IN `ID` INT, OUT `AMT` DECIMAL(8,2)) NO SQL
BEGIN
UPDATE invoicesales 
SET date=SYSDATE(), amount=(SELECT SUM(cost) FROM on_hold WHERE on_hold.id=id) 
WHERE invoicesales.id=id;
SELECT total_amount INTO AMT FROM invoicesales WHERE id=id;
END$$

-- Functions
CREATE DEFINER=`root`@`localhost` FUNCTION `P_AMT` (`start` DATE, `end` DATE) RETURNS DECIMAL(8,2) NO SQL
DETERMINISTIC
BEGIN
DECLARE PAMT DECIMAL(8,2) DEFAULT 0.0;
SELECT SUM(P_COST) INTO PAMT FROM PURCHASE WHERE PUR_DATE >= start AND PUR_DATE<= end;
RETURN PAMT;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `S_AMT` (`start` DATE, `end` DATE) RETURNS DECIMAL(8,2) NO SQL
BEGIN
DECLARE SAMT DECIMAL(8,2) DEFAULT 0.0;
SELECT SUM(total_amount) INTO SAMT FROM invoicesales WHERE date >= start AND date<= end;
RETURN SAMT;
END$$

DELIMITER ;
