###extraer las variables en arreglos


def extraer_redcap(URL, API_KEY , VARIABLES_REDCap):
    
    from redcap import Project, RedcapError
    project = Project(URL, API_KEY)
    fields_of_interest = VARIABLES_REDCap
    subset = project.export_records(fields=fields_of_interest)

    return subset

CRIADEROS=extraer_redcap('http://claimproject.com/redcap570/api/',
                         '5652F3927DF45881270EAF3F0FA7153A' ,
                         ['id_study', 'cd_house', 'no_latitude1','no_length1','cd_site'] ) 


## IN: List of Houses Out: List of Houeses that have longitude and latitude.
def eliminar_encuestas_sin_coordenadas(subset):
        COORDENADAS=[]
        for i in subset:
             if len(i['no_latitude1']) > 0 and len(i['no_length1']) > 0 :
                 COORDENADAS.append(i)
        return COORDENADAS

    
def lista_de_casas(subset):
    casas = []
    codigos=[]
    for i in subset:
        if i['cd_house'] not in codigos:
             casas.append(i)
             A=i['cd_house']
             codigos.append(A)
    return casas

##def lista_de_cabi(subset):
##    cabi = []
##   
##    for i in subset:
##        if i['cd_site'] == '23':
##             cabi.append(i)
##             
##             
##    return cabi


	
def criaderos_to_php(SUBSET):
    for i in SUBSET:
        print i['id_study']
        print i['cd_house']
        print i['no_latitude1']
        print i['no_length1']
        print i['cd_site']
        ##if i['urbano']=='1':
           ## print i['urbano']
        ##else: print '0'
        ##if i['periurban']=='1':
           ## print i['periurban']
        ##else: print '0'
        ##if i['rural']=='1':
           ## print i['rural']
        ##else: print '0'
        
        
        
		
        
##print len (CRIADEROS)
CRIADEROS1=eliminar_encuestas_sin_coordenadas(CRIADEROS)

#CRIADEROS1=lista_de_cabi(CRIADEROS1)

criaderos_to_php(CRIADEROS1)


##
##        
##        
##print len(SINTOMAS)
##print "-bbb-"
##print len(D)







    
