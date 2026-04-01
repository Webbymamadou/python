class Billet : 
    TVA = 0.18
    DEVISE = "FCFA"
    condition_generale = "Non renbousable sauf annulation du voyage"
    nbre_billets_vendus  = 0
    def __init__(self , depart , destination , prix_ht , date_depart , passager):
        self.depart = depart
        self.destination = destination
        self.prix_ht = prix_ht
        self.date_depart = date_depart
        self.passager = passager
        Billet.nbre_billets_vendus +=1
    
    def prix_ttc(self):
        return self.prix_ht * (1 + Billet.TVA)
    
    def afficher_billet(self):
        return f"""  
        ----BILLET DE VOYAGE----
        Passager : {self.passager}
        Destination : {self.depart} --> {self.destination}
        Date de depart : {self.date_depart}
        Prix_HT : {self.prix_ht}{Billet.DEVISE}
        Prix_TTC : {self.prix_ttc()}{Billet.DEVISE}
        Conditions generale : {Billet.condition_generale}
        ------------------------
    """
    def application_reduction(self , pourcentage):
        return self.prix_ht * (pourcentage /100)
            
    def __str__(self):
        return f"Billet de {self.passager} , date de depart : {self.date_depart}h et destination : {self.destination}"
    
    @classmethod
    def changer_TVA(cls , nouvelle_tva):
        cls.TVA = nouvelle_tva
        print(f"La TVA a ete modifie {cls.TVA * 100}%")

    @classmethod
    def afficher_statistique(cls):
        print(f"Le nombre total de billets vendus est {cls.nbre_billets_vendus} billets") 
    
print("======== Les informations nos clients ==========")
b1 = Billet("Dakar" , "saint_louis" , 12000 , 20 , "Mamadou seck")
print(b1)
print(f"Le prix tout taxe est :{b1.prix_ttc()}\n")  
print(b1.afficher_billet())

b2 = Billet("Thies" , "Dakar" , 13000 , 19 , "Aziz Diop")
print(b2)
print(f"Le prix tout taxe est :{b2.prix_ttc()}\n")  
print(b2.afficher_billet())

b3 = Billet("Fouta" , "Matam" , 15000 , 18 , "Monsieur Ndiaye")
print(b3) 
print(f"Le prix tout taxe est :{b3.prix_ttc()}\n") 
print(b3.afficher_billet())

b4 = Billet("Matam" , "Fouta" , 11000 , 7 , "Diop 2")
print(b4)
print(f"Le prix tout taxe est :{b4.prix_ttc()}\n")  
print(b4.afficher_billet())

Billet.afficher_statistique()
Billet.changer_TVA(0.19)
print("="*70)
