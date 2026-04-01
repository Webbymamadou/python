class Produit : 
    Devise = "FCFA"
    def __init__(self , nom , prix_base , taux_remise , quantite):
        self.__nom = nom
        self.__prix_base = prix_base
        self.__taux_remise =  taux_remise
        self.__quantite = quantite
        
    @property
    def nom(self):
        return self.__nom
    
    @property
    def prix_base(self):
        return self.__prix_base
    
    @property
    def taux_remise(self):
        return self.__taux_remise
    
    @property
    def quantite(self):
        return self.__quantite
    
    @property
    def montant_remise(self):
        return self.__prix_base * self.__taux_remise
    
    @property
    def prix_apres_remise(self):
        return self.__prix_base - self.montant_remise
    
    @property
    def tva(self):
        return self.prix_apres_remise * 0.18
    
    @property
    def prix_ttc(self):
        return self.prix_apres_remise + self.tva
    
    @property
    def valeur_stoks(self):
        return self.prix_ttc * self.__quantite
    
    def appliquer_promo(self , nouveau_taux):
        if 0 <= nouveau_taux <= 1 : 
            self.__taux_remise = nouveau_taux
            print(f"le promo appliquer sur {self.__nom} est de : {self.__taux_remise * 100}%")
        else : 
            print ("Le taux doit etre compris entre 0 et 100")

    @classmethod
    def creer_produit_solde(cls , nom , prix , taux):
        return cls(nom , prix , taux , 2)
    
    def __str__(self):
        return f"{self.nom} achete - prix {self.prix_base} {Produit.Devise} - Quantite :{self.quantite} {self.nom}"
        
P1=Produit("casque" , 4000 , 0.15 , 3)
P1.appliquer_promo(0.30)
print(f"Le prix avant la reduction est de : {P1.prix_ttc}")
print(f"La valeur du stock est de : {P1.valeur_stoks}")
print(f"{P1}\n")

P2=Produit("Telephone" , 60000 , 0.15 , 1)
P2.appliquer_promo(0.18)
print(f"Le prix avant la reduction est de : {P2.prix_ttc}")
print(f"La valeur du stock est de : {P2.valeur_stoks}")
print(f"{P2}\n")

P3=Produit("Ordinateurs" , 140000 , 0.15 , 2)
P3.appliquer_promo(0.50)
print(f"Le prix avant la reduction est de : {P3.prix_ttc}")
print(f"La valeur du stock est de : {P3.valeur_stoks}")
print(f"{P3}\n")
