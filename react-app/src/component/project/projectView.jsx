import React, {Component} from 'react';
import ProjectInfo from  './projectInfo.jsx';
import AddButton from '../button/addButton.jsx';
import ProjectServiceset from './projectServiceset.jsx'


class ProjectView extends Component {

    render() {
        const info = {path: "#", buttonName: "Создать"};
        console.log(info);
        const project = {
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
        console.log(project);

        const servicesetInfo = {
            id: "43",
            id_state: "0",
            delivery: "",
            payment: "",
            isOpen: "1",
            list: ["Установление контакта", "Выявление потребностей", "Выставление счета", "Оплата", "Поставка", "Завершено", "Отказ"]
        };

        console.log(servicesetInfo);

        return (
            <div>
                <ProjectInfo projectInfo = {project}/>
                <AddButton buttonInfo={info}/>

            </div>
        );
    }
}


export default ProjectView;