CREATE VIEW v_contributors AS (select c.ruc,c.razon_social,c.ubigeo,u.departamento,u.provincia,u.distrito,
CONCAT(CASE
  WHEN c.nombre_via!='-' then concat(c.tipo_via,' ',c.nombre_via, CASE
    WHEN c.numero!='-' then concat(' NRO. ',c.numero)
    WHEN c.manzana!='-' then concat(' MZA. ',c.manzana,' LOTE ',c.lote)
    ELSE concat(' KM. ',c.kilometro)
    END)
  ELSE concat('MZA. ',c.manzana,' LOTE ',c.lote)
  END,
  CASE WHEN c.departamento!='-' then concat(' DPTO. ',c.departamento) else concat('') END,
  CASE WHEN c.interior!='-' then concat(' INT. ',c.interior) else concat('') END,
  CASE WHEN c.tipo_zona!='-' then concat(case
    WHEN c.codigo_zona='----' then concat(' ',c.tipo_zona)
    ELSE concat(' ',c.codigo_zona,' ',c.tipo_zona) END
    ) else concat('') END
) as direccion
from contributors as c, ubigeos as u where c.ubigeo=u.code);