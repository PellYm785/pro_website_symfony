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

    for (var type in competencesData){
        console.log(competencesData[type]);
        var groupeComp = new Category(competencesData[type][0].type);

        competencesData[type].forEach(function (competence) {
            groupeComp.add(new Item(competence.nom,''));
        });

        competences.add(groupeComp);
    }

    console.log(cvData);
    console.log(competences);
    //console.log(experiences);
    //console.log(formations);
});
console.log('ok');