--  afiliados que estan activos en uom y tiene fecha de baja cargado
select a.* from afiliados as a
inner join padron_uom as p
on a.nro_doc = p.nro_doc
and not (fecha_egreso is null or ifnull(motivo_egreso_id, 0) = 0)

--  afiliados sin cuil
select * from afiliados
where cuil is null
and fecha_egreso is null



