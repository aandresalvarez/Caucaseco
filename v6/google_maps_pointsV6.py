

####extraer las variables en arreglos


def extraer_redcap(URL, API_KEY , VARIABLES_REDCap):
    
    from redcap import Project, RedcapError
##    URL = 'http://claimproject.com/redcap570/api/'
##    API_KEY_SOCIODEMOGRAFICA = 'FC8BD5EE83AE0DECD2BF247031BD028E'
##    API_KEY_SINTOMAS ='744F5C67890BDA39B9CC2B4A9CE77F12';
    project = Project(URL, API_KEY)
    fields_of_interest = VARIABLES_REDCap
    subset = project.export_records(fields=fields_of_interest)

    return subset


   

def  guardar_en_txt (NOMBRE_DEL_ARCHIVO , SUBSET):
    archi=open(NOMBRE_DEL_ARCHIVO,'w')
    archi.close()
    archi=open(NOMBRE_DEL_ARCHIVO,'a')
    for  i in  SUBSET:
##        if i['cd_country']=='1' and len(i['no_latitude1']) > 0 and len(i['no_length1']) > 0:
            archi.write( i['id_study'])
            archi.write( "\n")
            archi.write(i['cd_site'])
            archi.write( "\n")
            archi.write(i['no_latitude1'])
            archi.write( "\n ")
            archi.write(i['no_length1'])
            archi.write( "\n")
        
    archi.close()

## Varialbes sociodemografica: id_study,cd_area,cd_site, dt_data_collection, cd_house,no_latitude1,no_length1
SOCIODEMOGRAFICA= extraer_redcap('http://claimproject.com/redcap570/api/','FC8BD5EE83AE0DECD2BF247031BD028E' ,['id_study','no_latitude1','no_length1','cd_country','cd_site','cd_area','dt_data_collection','cd_house'] )
## varialbes sintomas : id_study, cd_site, cd_area,dt_data_collection,nm_result_pcr,cd_house,rt_pcr 
SINTOMAS= extraer_redcap('http://claimproject.com/redcap570/api/',
                         '744F5C67890BDA39B9CC2B4A9CE77F12' ,
                         ['id_study', 'cd_site', 'cd_area','cd_country','dt_data_collection','nm_result_pcr','cd_house','rt_pcr'] )

##guardar_en_txt("ejemplo.txt",C)

def positivos_malaria_pais(SUBSET_SINTOMAS):
    POSITIVOS=[]
    
    for  i in  SUBSET_SINTOMAS:
        if i['nm_result_pcr'] =='1':
            POSITIVOS.append(i)
            
                    
    return POSITIVOS

def positivos_dengue_pais(SUBSET_SINTOMAS):
    POSITIVOS=[]

    for i in SUBSET_SINTOMAS:
        if i['rt_pcr']=='1':
            POSITIVOS.append(i)
    return POSITIVOS
        
def casas_colombia(SUBSET_SOCIODEMOGRAFICA):
    CASAS_COLOMBIA=[]
    for  i in  SUBSET_SOCIODEMOGRAFICA:
    
            CASAS_COLOMBIA.append(i)
            
    return CASAS_COLOMBIA

##verifica si un codigo de casa dado esta en la lsita de casas
def esta_la_casa_en_la_lista(CASAS,CD_HOUSE):
    tmp=0
    for i in CASAS:
       if i['cd_house']==CD_HOUSE:
          tmp=tmp+1

    if tmp>1:
        return True
    else:
        return False
    

def casas_con_positivos_de_malaria(POSITIVOS_MALARIA_PAIS, CASAS_COLOMBIA):
    Indice=0
    for i in  CASAS_COLOMBIA:
        CASAS_COLOMBIA[Indice]['Malaria_Positivo']='0'
        for j in POSITIVOS_MALARIA_PAIS:
            A=i['dt_data_collection']
            B=j['dt_data_collection']
            DICCIONARIO_TEMPORAL=i
            if A[:4]== B[:4] and  i['cd_site']==j['cd_site'] and i['cd_house']==j['cd_house']:
                CASAS_COLOMBIA[Indice]['Malaria_Positivo']='1'
                
        Indice=Indice+1
    return CASAS_COLOMBIA



def casas_con_positivos_de_dengue(POSITIVOS_DENGUE_PAIS, CASAS_COLOMBIA):
    Indice=0
    for i in  CASAS_COLOMBIA:
        CASAS_COLOMBIA[Indice]['Dengue_Positivo']='0'
        for j in POSITIVOS_DENGUE_PAIS:
            A=i['dt_data_collection']
            B=j['dt_data_collection']
            DICCIONARIO_TEMPORAL=i
            if A[:4]== B[:4] and  i['cd_site']==j['cd_site'] and i['cd_house']==j['cd_house']:
                CASAS_COLOMBIA[Indice]['Dengue_Positivo']='1'
                
        Indice=Indice+1
    return CASAS_COLOMBIA


def eliminar_casas_sin_coordenadas(subset):
        CASAS_POSITIVAS_CON_COORDENADAS=[]
        for i in subset:
             if len(i['no_latitude1']) > 0 and len(i['no_length1']) > 0:
                 CASAS_POSITIVAS_CON_COORDENADAS.append(i)
        return CASAS_POSITIVAS_CON_COORDENADAS
        
def to_php(SUBSET):
##    M=[]
##    j=0
    for i in SUBSET:
        YEAR=i['dt_data_collection']
        print i['id_study']
        print i['no_latitude1']
        print i['no_length1']
        print i['cd_country']
        print i['Malaria_Positivo']
        print YEAR[:4]
        print i['cd_area']
        print i['cd_site']
        print i['cd_house']
        print i['Dengue_Positivo']
        
        
        
        

##    return M           

CASOS_POSITIVOS_DENGUE= positivos_dengue_pais(SINTOMAS)

CASOS_POSITIVOS_MALARIA= positivos_malaria_pais(SINTOMAS)
CASAS_COLOMBIA= casas_colombia(SOCIODEMOGRAFICA)
CASAS_CON_MALARIA=casas_con_positivos_de_malaria(CASOS_POSITIVOS_MALARIA,CASAS_COLOMBIA)
CASAS_CON_MALARIA=eliminar_casas_sin_coordenadas(CASAS_CON_MALARIA)

CASAS_CON_DENGUE_Y_MALARIA=casas_con_positivos_de_dengue(CASOS_POSITIVOS_DENGUE,CASAS_CON_MALARIA)

to_php(CASAS_CON_DENGUE_Y_MALARIA)


##
##        
##        
##print len(SINTOMAS)
##print "-bbb-"
##print len(D)







    
