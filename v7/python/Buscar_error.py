

####extraer las variables en arreglos


def extraer_redcap(URL, API_KEY , VARIABLES_REDCap):
    
    from redcap import Project, RedcapError
    project = Project(URL, API_KEY)
    fields_of_interest = VARIABLES_REDCap
    subset = project.export_records(fields=fields_of_interest)

    return subset

CRIADEROS=extraer_redcap('http://claimproject.com/redcap570/api/',
                         '9C234F7AC8E851BBCB73FFD2820C6D76' ,
                         ['record_id', 'cd_house', 'latitud','longitud','urbano','periurban','rural','cd_site'] ) 


## IN: List of Houses Out: List of Houeses that have longitude and latitude.
def eliminar_criaderos_sin_coordenadas(subset):
        CRIADEROS_CON_COORDENADAS=[]
        for i in subset:
             if len(i['latitud']) >= 5.1342 and len(i['latitud']) >= 5.65804  and len(i['longitud']) >= 76.6167  and len(i['longitud']) >= 76.66211 :
                 CRIADEROS_CON_COORDENADAS.append(i)
        return CRIADEROS_CON_COORDENADAS

    
def lista_de_casas(subset):
    casas = []
    codigos=[]
    for i in subset:
        if i['cd_house'] not in codigos:
             casas.append(i)
             A=i['cd_house']
             codigos.append(A)
    return casas

'''def lista_de_cabi(subset):
    cabi = []
   
    for i in subset:
        if i['cd_site'] == '25':
             cabi.append(i)
             
             
    return cabi '''


	
def criaderos_to_php(SUBSET):
    for i in SUBSET:
        ##print i['record_id']
        print i['cd_house']
        '''print i['latitud']
        print i['longitud']
        if i['urbano']=='1':
            print i['urbano']
        else: print '0'
        if i['periurban']=='1':
            print i['periurban']
        else: print '0'
        if i['rural']=='1':
            print i['rural']
        else: print '0'''
        
        
        
		
        
##print len (CRIADEROS)
CRIADEROS1=eliminar_criaderos_sin_coordenadas(CRIADEROS)
##CRIADEROS1=lista_de_casas(CRIADEROS1)
##CRIADEROS1=lista_de_cabi(CRIADEROS1)

criaderos_to_php(CRIADEROS1)


##
##        
##        
##print len(SINTOMAS)
##print "-bbb-"
##print len(D)







    
