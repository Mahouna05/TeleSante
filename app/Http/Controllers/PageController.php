getMedecins();
        $services = $this->getServices();
        
        return view('pages.accueil', compact('medecins', 'services'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function aPropos()
    {
        return view('pages.a-propos');
    }

    public function connexion()
    {
        return view('pages.connexion');
    }

    public function inscription()
    {
        return view('pages.inscription');
    }

    // Méthodes pour simuler des données (en attendant une base de données)
    private function getMedecins()
    {
        return [
            [
                'nom' => 'Dr. Kokou Mensah',
                'specialite' => 'Médecine générale',
                'note' => 4.2,
                'photo' => 'img/doctors/doctor1.jpg'
            ],
            [
                'nom' => 'Dr. Aminata Diallo',
                'specialite' => 'Pédiatrie',
                'note' => 4.9,
                'photo' => 'img/doctors/doctor2.jpg'
            ],
            [
                'nom' => 'Dr. Olivier Adeyemi',
                'specialite' => 'Cardiologie',
                'note' => 4.5,
                'photo' => 'img/doctors/doctor3.jpg'
            ],
            [
                'nom' => 'Dr. Fatou Ndiaye',
                'specialite' => 'Médecine générale',
                'note' => 4.2,
                'photo' => 'img/doctors/doctor4.jpg'
            ],
            [
                'nom' => 'Dr. Pascal Koffi',
                'specialite' => 'Dermatologie',
                'note' => 4.2,
                'photo' => 'img/doctors/doctor5.jpg'
            ],
            [
                'nom' => 'Dr. Marie Amoussou',
                'specialite' => 'Gynécologie',
                'note' => 4.2,
                'photo' => 'img/doctors/doctor6.jpg'
            ],
            [
                'nom' => 'Dr. Jean Togbe',
                'specialite' => 'Ophtalmologie',
                'note' => 4.2,
                'photo' => 'img/doctors/doctor7.jpg'
            ],
            [
                'nom' => 'Dr. Sylvie Agossa',
                'specialite' => 'Psychiatrie',
                'note' => 4.2,
                'photo' => 'img/doctors/doctor8.jpg'
            ],
        ];
    }

    private function getServices()
    {
        return [
            [
                'icon' => '👨‍⚕️',
                'titre' => 'Consultation à distance',
                'description' => 'Consultez un médecin par vidéo ou chat sans vous déplacer'
            ],
            [
                'icon' => '📋',
                'titre' => 'Dossier médical',
                'description' => 'Accédez à votre historique médical en toute sécurité'
            ],
            [
                'icon' => '💊',
                'titre' => 'Livraison médicaments',
                'description' => 'Recevez vos médicaments directement chez vous'
            ],
            [
                'icon' => '🔔',
                'titre' => 'Rappels',
                'description' => 'Recevez des notifications de rappel de vos rendez-vous!'
            ],
            [
                'icon' => '🔒',
                'titre' => 'Paiements sécurisé',
                'description' => 'Payez vos consultations'
            ],
            [
                'icon' => '🚚',
                'titre' => 'Livraison rapide',
                'description' => 'Recevez vos médicaments directement chez vous'
            ],
        ];
    }
