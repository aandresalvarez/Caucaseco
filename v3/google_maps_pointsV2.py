
def extraer_redcap():
    from redcap import Project, RedcapError
    URL = 'http://claimproject.com/redcap570/api/'
    API_KEY = 'FC8BD5EE83AE0DECD2BF247031BD028E'
    project = Project(URL, API_KEY)
    fields_of_interest = ['id_study','no_latitude1','no_length1','cd_country']
    subset = project.export_records(fields=fields_of_interest)


    archi=open('datos.txt','w')
    archi.close()
    archi=open('datos.txt','a')
    for  i in  subset:
        if i['cd_country']=='1' and len(i['no_latitude1']) > 0 and len(i['no_length1']) > 0:
            archi.write( i['id_study'])
            archi.write( "\n")
##            archi.write(i['cd_country'])
##            archi.write( "\n")
            archi.write(i['no_latitude1'])
            archi.write( "\n ")
            archi.write(i['no_length1'])
            archi.write( "\n")
        
    archi.close()

extraer_redcap()
