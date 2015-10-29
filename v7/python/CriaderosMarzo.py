

####extraer las variables en arreglos


def extraer_redcap(URL, API_KEY , VARIABLES_REDCap):
    
    from redcap import Project, RedcapError
    project = Project(URL, API_KEY)
    fields_of_interest = VARIABLES_REDCap
    subset = project.export_records(fields=fields_of_interest)

    return subset

CRIADEROS=extraer_redcap('http://claimproject.com/redcap570/api/',
                         '4D799355E8B4D98A50735A12397AC287' ,
                         ['latitude','longitude','mosquito_breeding_code'] ) 


## IN: List of Houses Out: List of Houeses that have longitude and latitude.
def eliminar_criaderos_sin_coordenadas(subset):
        CRIADEROS_CON_COORDENADAS=[]
        for i in subset:
             
             if len(i['latitude']) > 0 and len(i['longitude']) > 0 or (i['longitude']!='9999' or i['latitude']!='9999') :
                 CRIADEROS_CON_COORDENADAS.append(i)
        return CRIADEROS_CON_COORDENADAS

    
'''def lista_de_casas(subset):
    casas = []
    codigos=[]
    for i in subset:
        if i['capture_code'] not in codigos:
             casas.append(i)
             A=i['capture_code']
             codigos.append(A)
    return casas'''


def criaderos_to_php(SUBSET):
    for i in SUBSET:
        #print i['consecutive']
        #print i['capture_code']
        print i['latitude']
        print i['longitude']
        print i['mosquito_breeding_code']
        #print i['nm_mosquito_nets_in_place']
		
        
##print len (CRIADEROS)
CRIADEROS1=eliminar_criaderos_sin_coordenadas(CRIADEROS)

##CRIADEROS1=lista_de_casas(CRIADEROS1)

criaderos_to_php(CRIADEROS1)


##
##        
##        
##print len(SINTOMAS)
##print "-bbb-"
##print len(D)







    
