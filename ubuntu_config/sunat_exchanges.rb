require 'open-uri'
require 'nokogiri'
require 'active_record'
require 'date'

ActiveRecord::Base.establish_connection(
 :adapter => "mysql2",
 :host => "localhost",
 :username=>"root",
 :password=>"44243484",
 :database => "padron"
)

class SunatExchange < ActiveRecord::Base
end

def is_number? string
  true if Float(string) rescue false
end

def getNumber(string)
    x = string.gsub("\n","")
    x = x.gsub("\r","")
    x = x.gsub("\t","")
    x = x.gsub(" ","")
    Float(string) if Float(string) rescue 0
end

# Desde el mes previo
year = Date.today.prev_month.strftime("%Y")
month = Date.today.prev_month.strftime("%m")
if (last_date = SunatExchange.where("fecha like '#{year}-#{month}%'").order(fecha: :desc).first)
    last_day = last_date.fecha.mday
else
    last_day = 0
end
page = Nokogiri::HTML(open("http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias?mes=#{month}&anho=#{year}"))
array = []
el = page.css('td')
for i in 0..(el.size-1)
    td = getNumber(el[i].text())
    if el[i].at_css("strong") and td > last_day
        array << [ fecha: "#{year}-#{month}-#{sprintf '%02d',td.to_i}", compra: getNumber(el[i+1].text()), venta: getNumber(el[i+2].text())]
        i += 2
    end
end
SunatExchange.create(array)


# Desde el mes actual
year = Date.today.strftime("%Y")
month = Date.today.strftime("%m")
if (last_date = SunatExchange.where("fecha like '#{year}-#{month}%'").order(fecha: :desc).first)
    last_day = last_date.fecha.mday
else
    last_day = 0
end
page = Nokogiri::HTML(open("http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias?mes=#{month}&anho=#{year}"))
array = []
el = page.css('td')
for i in 0..(el.size-1)
    td = getNumber(el[i].text())
    if el[i].at_css("strong") and td > last_day
        array << [ fecha: "#{year}-#{month}-#{sprintf '%02d',td.to_i}", compra: getNumber(el[i+1].text()), venta: getNumber(el[i+2].text())]
        i += 2
    end
end
SunatExchange.create(array)