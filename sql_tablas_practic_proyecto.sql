create database practic;

CREATE TABLE clientes
(
  id bigserial ,
  nombre_cliente text NOT NULL default '',
  --apellido_cliente character varying(10) NOT NULL default '',
  telefono text default '' ,
  activo boolean default '0' ,
  keyt text default '',
  imagen text default '',
  pin text default '' ,
  correo text default '',
  fecha_nacimiento text default '',
  sexo text default '',
  primary key(id)
);

UPDATE clientes SET activo ='0', sexo = 'masculino' WHERE telefono=5804268210636

INSERT INTO clientes(nombre_cliente,telefono,activo,keyt,imagen,pin) VALUES('nombre_temporal','+582323232','0','23343','no_imagen',11111)

SELECT cli.nombre_cliente,cli.telefono,cli.activo,cli.keyt FROM clientes cli WHERE cli.telefono = '5804268210636'

UPDATE clientes SET imagen = 'si' WHERE id=3

SELECT cli.id, cli.telefono, cli.nombre_cliente, cli.imagen FROM clientes cli WHERE cli.telefono = '10001'

insert into clientes(nombre_cliente,telefono,activo,keyt,imagen) values('Alfonzo Bruno',10001,'1','key1','no_imagen');
insert into clientes(nombre_cliente,telefono,activo,keyt,imagen) values('Julio Camacho',10002,'1','key2','no_imagen');
insert into clientes(nombre_cliente,telefono,activo,keyt,imagen) values('Elias Rodriguez',10003,'1','key3','no_imagen');

SELECT cli.id, cli.telefono FROM clientes cli WHERE cli.telefono = '10078872'

SELECT count(c.id) AS cant_total FROM clientes c WHERE c.telefono = '10002' 



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

insert into tarjetas_stripe(id_cliente,stripe_code,tipo,ultimos_digitos,activo) values(1,'4323777','debito',777,'1');
insert into tarjetas_stripe(id_cliente,stripe_code,tipo,ultimos_digitos,activo) values(2,'6765888','credito',888,'1');
insert into tarjetas_stripe(id_cliente,stripe_code,tipo,ultimos_digitos,activo) values(3,'89769999','debito',999,'1');




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

UPDATE transacciones SET valor = 9000 WHERE valor=-3

INSERT INTO transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta, stripe_id,transaccion_id) VALUES('22-02-2019',1,1000,'primer deposito','bien',1,'1','1') ;
insert into transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta,stripe_id,transaccion_id) values('03-02-2019',2,1000,'primer deposito','estuvo bien',2,'1','1');
insert into transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta,stripe_id,transaccion_id) values('06-02-2019',3,1000,'primer deposito','estuvo bien',3,'1','1');


------------------
SELECT t.id, t.fecha, t.descripcion, t.valor, t.id_cliente, t.observacion, c.nombre_cliente AS saldo FROM transacciones t INNER JOIN clientes c ON t.id_cliente = c.id WHERE t.id_cliente = 5 ORDER BY t.id DESC limit 10
-------
SELECT c.id, t.fecha, c.nombre_cliente, t.descripcion FROM clientes c INNER JOIN transacciones t ON c.id = t.id_cliente WHERE t.id_cliente =6 AND t.fecha BETWEEN '2019-02-28' AND '2019-09-01';
---sub consulta
SELECT sum(valor) AS saldo_total FROM (SELECT tr.id_cliente, tr.descripcion, tr.valor FROM transacciones tr WHERE tr.id_cliente =6 ORDER BY tr.id DESC 
) AS sub_tran  WHERE id_cliente = 6 AND valor >0;



SELECT t.id, t.fecha, t.descripcion FROM transacciones t WHERE t.id_cliente ='1' AND t.fecha BETWEEN '2019-03-01' AND '2019-03-04';


SELECT sum(t.valor) AS saldo_total FROM transacciones t WHERE t.id_cliente = 6

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
  --fecha_caducidad date NOT NULL,
  fecha_caducidad TIMESTAMP,
  id_cliente bigint NOT NULL default 0,
  primary key(id)
);

insert into claves(clave,fecha_caducidad,id_cliente) values(4567,'02-08-2019',2);
SELECT count(cli.id) as cantidad FROM clientes cli WHERE cli.telefono = '11111'
SELECT cla.id, cla.clave, cla.fecha_caducidad FROM claves cla WHERE cla.id_cliente = '1' ORDER BY cla.id DESC LIMIT 1

UPDATE claves SET clave ='111' WHERE id_cliente='1' AND fecha_caducidad = $
UPDATE clientes SET keyt ='21212-121212' WHERE id='1'
