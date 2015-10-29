


   


def extraer_redcap(URL, API_KEY , VARIABLES_REDCap):
    
    from redcap import Project, RedcapError
    project = Project(URL, API_KEY)
    fields_of_interest = VARIABLES_REDCap
    subset = project.export_records(fields=fields_of_interest)

    return subset

## Varialbes SIVIGILA
SIVIGILA=extraer_redcap('http://claimproject.com/redcap570/api/','76E7CF15DACACBA580A2DB83F6BF663D' ,
                        ['id_autonumerico','ano','ndep_proce','nmun_proce','vereda_','nom_eve'] )



## IN: List of Houses Out: List of Houeses that have longitude and latitude.
def eliminar_criaderos_sin_coordenadas(subset):
        CRIADEROS_CON_COORDENADAS=[]
        for i in subset:
             if len(i['latitude']) > 0 and len(i['longitude']) > 0  and i['distance_nearest_house']!='9999':
                 CRIADEROS_CON_COORDENADAS.append(i)
        return CRIADEROS_CON_COORDENADAS

def lista_departamentos(SUBSET):
    departamentos=[]
    for i in SUBSET:
        if i['ndep_proce'] not in departamentos:
            departamentos.append(i['ndep_proce'])
    return departamentos

def lista_paracitos(SUBSET):
    paracitos=[]
    for i in SUBSET:
        if i['nom_eve'] not in paracitos:
            paracitos.append(i['nom_eve'])
    return paracitos

def casos_tipo_de_malaria_por_departamento(departamento,paracito,subset):
    cont_paracito=0
    for i in subset:
       
        if departamento==i['ndep_proce'] and paracito==i['nom_eve']:
            cont_paracito=cont_paracito+1

    return cont_paracito
            
            
def crear_tabla_casos(departamentos, paracitos,subset):
    for i in departamentos:
        for j in paracitos:
            cont_casos=casos_tipo_de_malaria_por_departamento(i,j,subset)
            if cont_casos >0 and len(str(i))>0 and len(str(j))>0:
                print i
                print j
                print cont_casos
                
                
            
            
            
    
            
##            tabla.append()
        
def criaderos_to_php(SUBSET):
    for i in SUBSET:
        print i['id_autonumerico']
        print i['ano']
        print i['ndep_proce']
        print i['nmun_proce']
        print i['vereda_']
        print i['nom_eve']
                
		
        
##print len (SIVIGILA)
####SIVIGILA=eliminar_criaderos_sin_coordenadas(SIVIGILA)
##print len (CRIADEROS1)

paracitos= lista_paracitos(SIVIGILA)
departamentos=lista_departamentos(SIVIGILA)
crear_tabla_casos(departamentos, paracitos,SIVIGILA)
##print casos_tipo_de_malaria_por_departamento('VALLE','MALARIA VIVAX',SIVIGILA)
####criaderos_to_php(SIVIGILA)


##
##        
##        
##print len(SINTOMAS)
##print "-bbb-"
##print len(D)


