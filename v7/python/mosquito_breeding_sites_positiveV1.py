

####extraer las variables en arreglos


def extraer_redcap(URL, API_KEY , VARIABLES_REDCap):
    
    from redcap import Project, RedcapError
    project = Project(URL, API_KEY)
    fields_of_interest = VARIABLES_REDCap
    subset = project.export_records(fields=fields_of_interest)
    
    return subset
## P2 transversal
##print "Descargando datos.."
CRIADEROS=extraer_redcap('http://claimproject.com/redcap570/api/',
                         '3F40C134AB18048FD695845BC1E6716F' ,
                         ['record_id', 'mosquito_breeding_code', 'latitude','longitude','distance_nearest_house','abm','ntv','dar','tri','ppp','cal','neo','permanent','temporal'] ) 
##print "Carga Terminada-"

## IN: List of Houses Out: List of Houeses that have longitude and latitude.
def eliminar_criaderos_sin_coordenadas(subset):
        CRIADEROS_CON_COORDENADAS=[]
        for i in subset:
             if len(i['latitude']) > 0 and len(i['longitude']) > 0 and i['longitude']!='9999' and i['latitude']!='9999' and i['distance_nearest_house']!='9999':
                 CRIADEROS_CON_COORDENADAS.append(i)
        return CRIADEROS_CON_COORDENADAS



#### saca los creiaderos positivos del estudio transversal
def criaderos_positivos(subset):
    CRIADEROS_POSITIVOS=[]
    for i in subset:
        if i['abm']>0 or i['ntv']>0 or i['dar']>0 or i['tri']>0 or i['ppp']>0 or i['cal']>0 or i['neo']>0:
           CRIADEROS_POSITIVOS.append(i)
          

    return CRIADEROS_POSITIVOS

## restornas los criaderos de la localidad dada
def criaderos_por_localidad(localidad,subset):
    CRIADEROS_LOCALIDAD=[]
    for i in subset:
        if i['site']==localidad:
           CRIADEROS_LOCALIDAD.append(i)
    return CRIADEROS_LOCALIDAD

## restorna los criaderos albimanus
def criaderos_abm(subset):
    CRIADEROS_ABM=[]
    for i in subset:
        if i['abm']>0:
           CRIADEROS_ABM.append(i)
           CRIADEROS_ABM[Indice]['Mosquito']='abm'
    return CRIADEROS_ABM

## restorna los criaderos ntv
def criaderos_ntv(subset):
    CRIADEROS_NTV=[]
    for i in subset:
        if i['ntv']>0:
           CRIADEROS_NTV.append(i)
    return CRIADEROS_NTV

 ## restorna los criaderos dar
def criaderos_dar(subset):
    CRIADEROS_dar=[]
    for i in subset:
        if i['dar']>0:
           CRIADEROS_dar.append(i)
    return CRIADEROS_dar          
    
 ## restorna los criaderos tri
def criaderos_tri(subset):
    CRIADEROS_tri=[]
    for i in subset:
        if i['tri']>0:
           CRIADEROS_tri.append(i)
    return CRIADEROS_tri

 ## retorna los criaderos ppp
def criaderos_tri(subset):
    CRIADEROS_ppp=[]
    for i in subset:
        if i['ppp']>0:
           CRIADEROS_ppp.append(i)
    return CRIADEROS_ppp

 ## retorna los criaderos cal
def criaderos_cal(subset):
    CRIADEROS_cal=[]
    for i in subset:
        if i['cal']>0:
           CRIADEROS_cal.append(i)
    return CRIADEROS_cal 
 ## restorna los criaderos neo
def criaderos_neo(subset):
    CRIADEROS_neo=[]
    for i in subset:
        if i['neo']>0:
           CRIADEROS_neo.append(i)
    return CRIADEROS_neo
####criadesros con temporalidad permanente 
def temporalidad_permanente(subset):
    temporalidad_permanente=[]
    for i in subset:
        if i['permanent']>0:
           temporalidad_permanente.append(i)
    return temporalidad_permanente

####criadesros con temporalidad temporal 
def temporalidad_temporal(subset):
    temporalidad_temporal=[]
    for i in subset:
        if i['temporal']>0:
           temporalidad_temporal.append(i)
    return temporalidad_temporal

    
 

def criaderos_to_php(SUBSET):
    for i in SUBSET:
        print i['record_id']
        print i['mosquito_breeding_code']
        print i['latitude']
        print i['longitude']
        print i['distance_nearest_house']
        print i['abm']
        print i['ntv']
        print i['dar']
        print i['tri']
        print i['ppp']
        print i['cal']
        print i['neo']
        
        
        
		
        
##print len (CRIADEROS)
CRIADEROS1=eliminar_criaderos_sin_coordenadas(CRIADEROS)
A=criaderos_positivos(CRIADEROS1)
A=criaderos_ntv(CRIADEROS1)
##print len (CRIADEROS1)
criaderos_to_php(A)


##print len(CRIADEROS1)

##
##        
##        
##print len(SINTOMAS)
##print "-bbb-"
##print len(D)







    
