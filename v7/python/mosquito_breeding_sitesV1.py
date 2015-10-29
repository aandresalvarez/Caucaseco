

####extraer las variables en arreglos


def extraer_redcap(URL, API_KEY , VARIABLES_REDCap):
    
    from redcap import Project, RedcapError
    project = Project(URL, API_KEY)
    fields_of_interest = VARIABLES_REDCap
    subset = project.export_records(fields=fields_of_interest)

    return subset
## P2 transversal
CRIADEROS=extraer_redcap('http://claimproject.com/redcap570/api/',
                         '3F40C134AB18048FD695845BC1E6716F' ,
                         ['record_id', 'mosquito_breeding_code', 'latitude','longitude','distance_nearest_house'] ) 


## IN: List of Houses Out: List of Houeses that have longitude and latitude.
def eliminar_criaderos_sin_coordenadas(subset):
        CRIADEROS_CON_COORDENADAS=[]
        for i in subset:
             if len(i['latitude']) > 0 and len(i['longitude']) > 0 and i['longitude']!='9999' and i['latitude']!='9999' and i['distance_nearest_house']!='9999':
                 CRIADEROS_CON_COORDENADAS.append(i)
        return CRIADEROS_CON_COORDENADAS


def criaderos_to_php(SUBSET):
    for i in SUBSET:
        print i['record_id']
        print i['mosquito_breeding_code']
        print i['latitude']
        print i['longitude']
        print i['distance_nearest_house']
		
        
##print len (CRIADEROS)
CRIADEROS1=eliminar_criaderos_sin_coordenadas(CRIADEROS)
##print len (CRIADEROS1)
criaderos_to_php(CRIADEROS1)
print len(CRIADEROS1)

##
##        
##        
##print len(SINTOMAS)
##print "-bbb-"
##print len(D)







    
