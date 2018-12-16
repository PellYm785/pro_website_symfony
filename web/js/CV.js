console.log('ok');
$.getJSON('/getCvJSON',function (cvData) {
    console.log('ok');
    var cv = new RI();
    var competencesData = cvData.competences;
    var experiencesData = cvData.experiences;
    var formationsData = cvData.formations;
    var typeCompData = cvData.typeComp;
    var typeNiveauData = cvData.typeNiveau;

    var competences = new Section('Competences');
    var experiences = new Section('Experiences');
    var formations = new Section('Formations');
    var groupeComp = null;
    var poste = null;

    for (var type in competencesData){
        groupeComp = new Category(competencesData[type][0].type);

        competencesData[type].forEach(function (competence) {
            groupeComp.add(new Item(competence.nom,''));
        });

        competences.add(groupeComp);
    }

    cv.add(competences);
    cv.build();
    
    experiencesData.forEach(function (experience) {
        poste = new Category(experience._type +' '+ experience._poste);
        poste.add(new Item(,))
    })
    console.log(experiencesData);

    //console.log(experiences);
    //console.log(formations);
});