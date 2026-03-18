select * from ds_valores.VU_BUSCA_TUSNE_PER where nombre like '%ROMERO%' OR NUMDOC='01234567' OR CODIGO='XXXXXXXX';
--vista: datos basicos

select * from ds_valores.VU_BUSCA_TUSNE_PER WHERE CODIGO LIKE '%XXXXX%';

select * from DS_VALORES.VU_BUSCA_TUSNE_PER_pen;
select * from DS_VALORES.VU_BUSCA_TUSNE_PER_pen_TALLERES where codigo like 'T%';

select * from DS_VALORES.VU_BUSCA_TUSNE_PER_Pen WHERE OBS LIKE '%TEST%';
select * from DS_VALORES.VU_BUSCA_TUSNE_PER_Pen_TALLERES where liquidacion = '131220260441299';
select * from DS_VALORES.VU_BUSCA_TUSNE_PER_Pen where codigo = 'C0000002';
select * from DS_VALORES.VU_BUSCA_TUSNE_PER;
select * from DS_VALORES.VU_BUSCA_TUSNE_PER WHERE CODIGO LIKE '%S1234567%';
--VU_CETPRO_BUS
select * from DS_VALORES.VU_BUSCA_TUSNE_PER_pag where liquidacion = '131220260565106';

SELECT text 
FROM all_views 
WHERE owner = 'DS_VALORES' 
  AND view_name = 'VU_BUSCA_TUSNE_PER';

--vista: todos los recibos por cetpro -> 
131220260564969
131220260564987
118420260565059--LIQUIDACION DE TALLERES
131220260565106
131220260566524--LIQUIDACION DE CONTRI PRUEBA
select ds_valores.fu_digito_generar('1312','23','O0001','XXXXXXXX','TEST')LIQUIDACION FROM DUAL;    

select * from smacargo where cgonumero = '131220260440587';
select * from smacgotri where cgonumero = '131220260440587';
select * from smacgotri where codcontri='T0000001';
select ds_valores.fu_digito_generar('1312','23','O0001','S0006634','TEST')LIQUIDACION FROM DUAL;

                                            

  

select a.cgonumero,trim(jcromero.stragg(' '||b.condescrip))concepto,trim(jcromero.stragg(b.congrupo||b.concodigo))congrucod 
        from smacgotri a, SMACONCEPTOD b, SMAPROCEDIM c where b.proccodigo=a.proccodigo and b.conanoref='2009' and b.concodigo=a.concodigo and
		c.proccodigo=a.proccodigo and c.procnroano='2009' AND ( B.CONCODIGO IN ('B0001','B0002','B0003') or b.concodigo like 'O%') AND a.cgonumero='131220260440587' group by cgonumero ;
        
    select * from smacgotri where cgonumero = '131220260440587';    
select * from smacarnom where mcncontrib='S1234567';
select ds_valores.fu_digito_generar('1312','23','O0004','S0006634','TEST')LIQUIDACION FROM DUAL;
generador de nro liquidacion 	     tusne | tarifario | identificador de curso | codigo | observacion}

select * from smacarnom where mcncontrib = 'S0005851';
select * from consulta;

EXPLAIN PLAN FOR
select * from smacarnom where  mcncontrib = 'S0005851';
SELECT * FROM TABLE( DBMS_XPLAN.DISPLAY )

SELECT * FROM MACARNOM ORDER BY MCNFECHREG DESC FETCH FIRST 10 ROWS ONLY;


  SELECT * FROM SMACONCEPTOD WHERE CONGRUPO = '23' AND CONCODIGO = 'B0001';
  
  SELECT * FROM SMACONCEPTOD WHERE CONGRUPO = '23' AND CONCODIGO = 'O0057';

select * from SMACONCEPTOD where CONDESCRIP LIKE '%Modulo De Ofim%';
select * from SMACONCEPTOD where CONDESCRIP like '%ESCUELA DEPORTIVA MUNICIPAL TEMPORADA DE VERANO%';
select * from SMACONCEPTOD where CONGRUPO LIKE '%23%' AND  CONCODIGO LIKE '%O%'; 


SELECT cols.column_name
FROM all_constraints cons, all_cons_columns cols
WHERE cols.table_name = 'smacarnom'
AND cons.constraint_type = 'P'
AND cons.constraint_name = cols.constraint_name
AND cons.owner = cols.owner
ORDER BY cols.position;

SELECT 
    cols.table_name, 
    cols.column_name, 
    cols.position, 
    cons.status, 
    cons.owner
FROM all_constraints cons
JOIN all_cons_columns cols ON cons.constraint_name = cols.constraint_name
WHERE cols.table_name = 'SMACARNOM' 
  AND cons.constraint_type = 'P';
  
  
  SELECT CONCODIGO, COUNT(*) 
FROM SMACONCEPTOD 
GROUP BY CONCODIGO 
HAVING COUNT(*) > 1;

  SELECT MCNCONTRIB, COUNT(*) 
FROM SMACARNOM 
GROUP BY MCNCONTRIB 
HAVING COUNT(*) > 1;


select * from SMACONCEPTOD where CONFECHREG > TO_DATE('2025-01-01', 'YYYY-MM-DD');
SELECT * FROM SMACONCEPTOD WHERE CONGRUPO = '23' AND CONCODIGO = 'O0057'  and CONESTADO='1';
SELECT ARECODIGO FROM SMACONCEPTOD;

SELECT * FROM smacgotri;
select * from smacargo where proccodigo like '%B03%';
SELECT * FROM admin.MAMANU1003;

select * from DS_VALORES.VU_CETPRO_BUS;


SELECT text 
FROM all_views 
WHERE owner = 'DS_VALORES' 
  AND view_name = 'VU_CETPRO_BUS';

SELECT * FROM smacgotri; -- CONTIENE EL CONGRUPO Y CONCODIGO 
select * from smacargo;
SELECT * FROM admin.MAMANU1003;

SELECT * FROM smacgotri where cgonumero = '131220260439853'; -- CONTIENE EL CONGRUPO Y CONCODIGO 
select * from smacargo where cgonumero = '131220260440175';
SELECT * FROM admin.MAMANU1003;
where cgonumero = '131220260440175';

select * from smacargo where CODCONTRI LIKE '%S0465942%';

SELECT * FROM SMACARNOM;

SELECT *
FROM SMACONCEPTOD 
WHERE CONGRUPO = '23' AND CONCODIGO = 'B0001' AND CONESTADO = '1';




SELECT * FROM SMAVIAS; --vias: pasarlo a año actual
SELECT * FROM SMAZONA; --zona: año actual
SELECT * FROM SMADESCRI where GENCODIGO like 'DOI%';
SELECT * FROM SMADISTRITO;
SELECT * FROM SMADISTRITO WHERE DISTRICODI= '12';

SELECT * FROM SMACARNOM where MCNCONTRIB like '%S1234567%';--PRUEBA DEL SISTEMA
SELECT * FROM SMACARNOM where MCNCONTRIB like 'C%';
SELECT * FROM SMACARNOM;

SELECT * FROM SMACARNOM  WHERE UPPER(MCNCONTRIB) LIKE '%YYYYYY%';
SELECT MCNTIPODI, MCNAPENOMB FROM SMACARNOM;

COMMIT;

SELECT * FROM SMACARNOM where MCNCONTRIB = 'T0000002';

DELETE FROM SMACARNOM 
WHERE MCNCONTRIB = 'T0000002';

DELETE FROM admin.MAMANU1003 
WHERE cgonumero = '131220260441243';

131220260441225
131220260441243
INSERT INTO SMACARNOM
         (MCNCONTRIB --codigo contribuyente 
          , MCNESTADO --ERE04 estado(activo)
          , MCNTIPO --TPE01 persona natural
          , MCNAPEPAT
          , MCNAPEMAT
          , MCNNOMBRE
          , MCNVIAS --codigo via: calle residencia 
          , MCNDIRE --descripcion de la via
          , MCNNUME --numero de casa
          , MCNDPTO --nro dpto
          , MCNCODURBA --cdo urbanizacion
          , MCNURBA --descripcion urbanizacion
          , MCNMANZ --manzana
          , MCNLOTE --lote
          , MCNAPENOMB --apellido-nombre / razon social (p.juridica)
          , MCNTIPODI --tipo documento => DOI001 = DNI
          , MCNNRODI --nro dni
          , MCNTIPTELE --tipo telefono
          , MCNROTELE --nro telefono
          , MCNEMAIL --mail
          , MCNDNI --dni
          , MCNRUC --ruc
          , DISTRICODI --nro 12: molina
          , MCNFECNAC --fecha nacimiento
          , CODCAT --codigo catastral
          , MCNFECHREG --fecha registro (a la hora)
          , MCNHORA --hora de registro
          , SEXO) 
         VALUES
         (v_codigo
          , v_estado
          , p_tipper
          , CASE WHEN (p_tipper = 'TPE01') THEN NULL ELSE TRIM(p_apepat) END
          , CASE WHEN (p_tipper = 'TPE01') THEN NULL ELSE TRIM(p_apemat) END
          , CASE WHEN (p_tipper = 'TPE01') THEN NULL ELSE TRIM(p_nombre) END
          , TRIM(p_codvia)
          , TRIM(p_nomvia)
          , TRIM(SUBSTR(p_numdir,1,9))
          , TRIM(SUBSTR(p_dptdir,1,9))
          , TRIM(p_codurb)
          , TRIM(p_nomurb)
          , TRIM(SUBSTR(p_mzadir,1,9))
          , TRIM(SUBSTR(p_lotdir,1,9))
          , TRIM(v_nomcom)
          , TRIM(p_tipdoc)
          , TRIM(p_numdoc)
          , TRIM(v_tiptel)
          , TRIM(v_numtel)
          , TRIM(p_correo)
          , TRIM(v_numdni)
          , TRIM(v_numruc)
          , TRIM(p_disdir)
          , v_fecnac
          , TRIM(p_codcat)
          , SYSDATE
          , TO_CHAR(SYSDATE,'HH24:MI:SS')
          , TRIM(p_tipsex));
          
INSERT INTO SMACARNOM
(MCNCONTRIB, MCNESTADO, MCNTIPO, MCNAPEPAT, MCNAPEMAT, MCNNOMBRE, 
 MCNVIAS, MCNDIRE, MCNNUME, MCNDPTO, MCNCODURBA, MCNURBA, 
 MCNMANZ, MCNLOTE, MCNAPENOMB, MCNTIPODI, MCNNRODI, 
 MCNTIPTELE, MCNROTELE, MCNEMAIL, MCNDNI, MCNRUC, 
 DISTRICODI, MCNFECNAC, CODCAT, MCNFECHREG, MCNHORA, SEXO) 
VALUES
('S1234567',        -- v_codigo (debe empezar con S para la vista)
 'ERE04',           -- v_estado
 'TPE01',           -- p_tipper (Persona Natural)
 'DEL',             -- Apellido Paterno
 'SISTEMA',         -- Apellido Materno
 'PRUEBA',          -- Nombre
 '001',             -- p_codvia
 'CALLE PRUEBA',    -- p_nomvia
 '123',             -- p_numdir
 NULL,              -- p_dptdir
 '001',             -- p_codurb
 'URB PRUEBA',      -- p_nomurb
 'A',               -- p_mzadir
 '10',              -- p_lotdir
 'DEL SISTEMA PRUEBA', -- v_nomcom (Nombre Completo)
 'DOI01',           -- p_tipdoc (DNI)
 '12345678',        -- p_numdoc
 '02',              -- v_tiptel (Celular)
 '999888777',       -- v_numtel
 'test@test.com',   -- p_correo
 '12345678',        -- MCNDNI
 NULL,              -- MCNRUC
 '12',              -- DISTRICODI (La Molina)
 TO_DATE('01/01/1990','DD/MM/YYYY'), -- v_fecnac
 NULL,              -- p_codcat
 SYSDATE,           -- MCNFECHREG
 TO_CHAR(SYSDATE,'HH24:MI:SS'), -- MCNHORA
 'M');              -- p_tipsex
 COMMIT