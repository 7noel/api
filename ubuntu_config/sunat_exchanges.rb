require 'open-uri'
require 'nokogiri'
require 'active_record'
require 'date'

ActiveRecord::Base.establish_connection(
 :adapter => "mysql2",
 :host => "localhost",
 :username=>"root",
 :password=>"",
 :database => "masaki"
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

def saveByMonth(month, year) 
    if (last_date = Exchange.where("fecha like '#{year}-#{month}%'").order(fecha: :desc).first)
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
    return true    
end

def getMonthPrevious
    ms = ['01', '02', '03', '04', '05', '06', '07', '08', '10', '11', '12']
    ys = [2015, 2016, 2017, 2018]
    ys.each { |year|
        ms.each { |month|
            saveByMonth(month, year)
        }
    }
end
# Desde el mes previo
year = Date.today.prev_month.strftime("%Y")
month = Date.today.prev_month.strftime("%m")
saveByMonth(month, year)
# if (last_date = SunatExchange.where("fecha like '#{year}-#{month}%'").order(fecha: :desc).first)
#     last_day = last_date.fecha.mday
# else
#     last_day = 0
# end
# page = Nokogiri::HTML(open("http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias?mes=#{month}&anho=#{year}"))
# array = []
# el = page.css('td')
# for i in 0..(el.size-1)
#     td = getNumber(el[i].text())
#     if el[i].at_css("strong") and td > last_day
#         array << [ fecha: "#{year}-#{month}-#{sprintf '%02d',td.to_i}", compra: getNumber(el[i+1].text()), venta: getNumber(el[i+2].text())]
#         i += 2
#     end
# end
# SunatExchange.create(array)


# Desde el mes actual
year = Date.today.strftime("%Y")
month = Date.today.strftime("%m")
saveByMonth(month, year)
# saveByMonth(month, year)
# if (last_date = SunatExchange.where("fecha like '#{year}-#{month}%'").order(fecha: :desc).first)
#     last_day = last_date.fecha.mday
# else
#     last_day = 0
# end
# page = Nokogiri::HTML(open("http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias?mes=#{month}&anho=#{year}"))
# array = []
# el = page.css('td')
# for i in 0..(el.size-1)
#     td = getNumber(el[i].text())
#     if el[i].at_css("strong") and td > last_day
#         array << [ fecha: "#{year}-#{month}-#{sprintf '%02d',td.to_i}", compra: getNumber(el[i+1].text()), venta: getNumber(el[i+2].text())]
#         i += 2
#     end
# end
# SunatExchange.create(array)