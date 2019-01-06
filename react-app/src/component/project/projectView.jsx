import React, {Component} from 'react';
import ProjectInfo from  './projectInfo.jsx';
import AddButton from '../button/addButton.jsx';


class ProjectView extends Component {

    render() {

        const info = {path: "#", buttonName: "Создать"};
        const projectInfo = {
            name: "Проект",
            updateButton: {
                path: "#",
                buttonName: "Изменить"
            },
            deleteButton: {
                path: "#",
                buttonName: "Удалить"
            },
            client: "ООО \"Организация\"",
            creation_date: "12-10-2015",
            comment: "Комментарий"
        };
        return (
            <div>
                <ProjectInfo projectInfo = {projectInfo}/>
                <AddButton buttonInfo = {info}  />
            </div>
        );
    }
}


export default ProjectView;