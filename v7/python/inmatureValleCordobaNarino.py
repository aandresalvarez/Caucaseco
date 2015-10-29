

####extraer las variables en arreglos


def extraer_redcap(URL, API_KEY , VARIABLES_REDCap):
    
    from redcap import Project, RedcapError
    project = Project(URL, API_KEY)
    fields_of_interest = VARIABLES_REDCap
    subset = project.export_records(fields=fields_of_interest)

    return subset

CRIADEROS=extraer_redcap('http://claimproject.com/redcap570/api/',
                         '7FB401843C0B9056690970003A56DC2A' ,
                         ['record_id','cd_criadero','latitud_','longitud_'] ) 


## IN: List of Houses Out: List of Houeses that have longitude and latitude.
def eliminar_criaderos_sin_coordenadas(subset):
        CRIADEROS_CON_COORDENADAS=[]
        for i in subset:
             
             if len(i['latitud_']) > 0 and len(i['longitud_']) > 0 or (i['longitud_']!='9999' or i['latitud_']!='9999') :
                 CRIADEROS_CON_COORDENADAS.append(i)
        return CRIADEROS_CON_COORDENADAS

    
def lista_de_casas(subset):
    casas = []
    codigos=[]
    for i in subset:
        if i['cd_criadero'] not in codigos:
             casas.append(i)
             A=i['cd_criadero']
             codigos.append(A)
    return casas


def criaderos_to_php(SUBSET):
    for i in SUBSET:
        print i['record_id']
        print i['cd_criadero']
        print i['latitud_']
        print i['longitud_']
        #print i['nm_mosquito_nets_in_place']
		
        
##print len (CRIADEROS)
CRIADEROS1=eliminar_criaderos_sin_coordenadas(CRIADEROS)

CRIADEROS1=lista_de_casas(CRIADEROS1)

criaderos_to_php(CRIADEROS1)


##
##        
##        
##print len(SINTOMAS)
##print "-bbb-"
##print len(D)







    
