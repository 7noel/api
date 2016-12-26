# encoding: UTF-8
require 'active_record'

ActiveRecord::Base.establish_connection(
 :adapter => "mysql2",
 :host => "localhost",
 :username=>"root",
 :password=>"44243484",
 :database => "padron"
)

ActiveRecord::Base.connection.execute('TRUNCATE TABLE contributors;')

sql = ''
sql_before = "INSERT INTO contributors (ruc, razon_social, estado, condicion_domicilio, ubigeo, tipo_via, nombre_via, codigo_zona, tipo_zona, numero, interior, lote, departamento ,manzana, kilometro) VALUES"
i = 0
count_insert = 0
size_insert = 200
File.open("/home/ubuntu/padron/padron_reducido_ruc.txt", "r:UTF-8").each_line do |line|
  i += 1
  next if i == 1
  line = line.encode('utf-8').force_encoding("iso-8859-1")
  line2 = line.split('|')
  if count_insert>0
    sql = sql + ","
  end
  sql = sql + '('
  (0..14).each do |m|
    sql = sql + ActiveRecord::Base.connection.quote(line2[m])
    if m < 14
      sql = sql + ','
    end
  end
  sql = sql + ')'
  count_insert += 1
  if count_insert >= size_insert
    sql = sql_before + sql + ";"
    ActiveRecord::Base.connection.execute(sql)
    sql = ''
    count_insert = 0
  end
  puts i
end

if sql.size>10
  sql = sql_before + sql + ";"
  ActiveRecord::Base.connection.execute(sql)
end