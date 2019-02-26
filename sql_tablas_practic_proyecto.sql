create database practic;

CREATE TABLE clientes
(
  id bigserial ,
  nombre_cliente text NOT NULL default '',
  --apellido_cliente character varying(10) NOT NULL default '',
  telefono integer NOT NULL default 0 ,
  activo boolean default '0' ,
  keyt text default '',
  primary key(id)
);

insert into clientes(nombre_cliente,telefono,activo,keyt) values('luis',123213,'1','asdsd');
insert into clientes(nombre_cliente,telefono,activo,keyt) values('pedro',4323,'1','apala');
insert into clientes(nombre_cliente,telefono,activo,keyt) values('carlos',564533,'1','lolala');

SELECT cli.id, cli.telefono, cli.nombre_cliente, cli.apellido_cliente FROM clientes cli WHERE cli.telefono = '123213'



CREATE TABLE tarjetas_stripe
(
  id bigserial,
  id_cliente bigint references clientes(id) NOT NULL default 0,
  stripe_code text NOT NULL default '',
  tipo text NOT NULL default '',
  ultimos_digitos text NOT NULL default '',
  activo boolean NOT NULL default '0',
  
  primary key(id)
);

insert into tarjetas_stripe(id_cliente,stripe_code,tipo,ultimos_digitos,activo) values(2,'r4323','debito',56,'1');
insert into tarjetas_stripe(id_cliente,stripe_code,tipo,ultimos_digitos,activo) values(1,'r6765','credito',34,'1');
insert into tarjetas_stripe(id_cliente,stripe_code,tipo,ultimos_digitos,activo) values(3,'r8976','debito',67,'1');

insert into tarjetas_stripe(id_cliente,stripe_code,tipo,ultimos_digitos,activo) values(1,'o3444','debito',45,'1');
insert into tarjetas_stripe(id_cliente,stripe_code,tipo,ultimos_digitos,activo) values(1,'d3433','credito',69,'1');
insert into tarjetas_stripe(id_cliente,stripe_code,tipo,ultimos_digitos,activo) values(1,'t4223','debito',90,'0');

SELECT ta.tipo, ta.ultimos_digitos FROM tarjetas_stripe ta WHERE ta.id_cliente = 1 AND ta.activo=true;







CREATE TABLE transacciones
(
  id bigserial,
  fecha DATE, 
  id_cliente bigint references clientes(id) NOT NULL,
  valor double precision default 0,
  descripcion text default '',
  observacion text default '',
  id_tarjeta bigint references tarjetas_stripe(id) NOT NULL,
  stripe_id text default '',
  transaccion_id text default '',
  
  primary key(id)
);

SELECT sum(t.valor) AS saldo_total FROM transacciones t WHERE t.id_cliente = 2 

SELECT t.id, t.fecha, t.descripcion, t.valor, t.id_cliente AS saldo FROM transacciones t WHERE t.id_cliente = 1 ORDER BY t.id limit 10.

INSERT INTO transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta, stripe_id,transaccion_id) VALUES('22-03-2019',2,100,'recibe','bien',1,'1','1') ;

insert into transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta,stripe_id,transaccion_id) values('03-03-2019',1,9833,'pago al carnicero','estuvo bien',2,'1','1');
insert into transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta,stripe_id,transaccion_id) values('06-02-2019',1,6745,'pago al ropero','estuvo bien',2,'1','1');

insert into transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta,stripe_id,transaccion_id) values('09-04-2019',1,765,'pago al taxi','estuvo bien',2,'1','1');


insert into transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta,stripe_id,transaccion_id) values('01-04-2019',1,4323,'pago al parquero','estuvo bien',1,'1','1');

SELECT cli.id, cli.telefono FROM clientes cli WHERE cli.telefono = 123213;

SELECT sum(tr.valor) AS total_valor FROM transacciones tr WHERE tr.id_cliente = 1;


SELECT tr.id, tr.fecha, tr.descripcion, tr.valor FROM transacciones tr WHERE tr.id_cliente = 1;
--trabajando subconsultas
SELECT tr.id, tr.fecha,tr.valor, (SELECT tra.id+(SELECT tran.id, tran.fecha, tran.id_cliente FROM transacciones tran WHERE tran.id_cliente = 1 GROUP BY tran.id) AS re_id FROM transacciones tra WHERE tra.id_cliente = 1) FROM transacciones tr WHERE tr.id_cliente = 1;

SELECT tran.id, tran.fecha, tran.id_cliente,(select sum(t.id_cliente) AS re FROM transacciones t WHERE t.id_cliente = tran.id_cliente and t.fecha = tran.fecha) FROM transacciones tran WHERE tran.id_cliente = 1 GROUP BY tran.fecha 
select tran.fecha, sum(tran.id_cliente) FROM transacciones tran GROUP BY tran.fecha

insert into transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta,stripe_id,transaccion_id) values('01-06-2019',2,8345,'pago al cerrajero','estuvo bien',2,'1','1');

SELECT cli.id, cli.telefono FROM clientes cli WHERE cli.telefono = 123213;
--create table prueba_tiempo (
--fecha_ingreso date,
--fecha TIMESTAMP DEFAULT now(),
--hora_ingreso time);
--Luego insertar algunos datos.
--insert into prueba_tiempo values (date(now()), '20:40');

insert into transacciones(id_cliente,nombre_transaccion,valor,descripcion) values(1,'pago_caja','12345','es lo que debo');


CREATE TABLE claves
(
  id bigserial,
  clave integer NOT NULL default 0,
  fecha_caducidad date NOT NULL,
  id_cliente bigint NOT NULL default 0,
  primary key(id)
);

insert into claves(clave,fecha_caducidad,id_cliente) values(4567,'02-08-2019',2);

