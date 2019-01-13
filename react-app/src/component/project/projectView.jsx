import React, {Component} from 'react';
import ProjectInfo from  './projectInfo.jsx';
import AddButton from '../button/addButton.jsx';
import ProjectServiceset from './projectServiceset.jsx';
import ProjectEvent from './projectEvent.jsx';


const API = '/api/projects/19';

class ProjectView extends Component {

    constructor(props) {
        super(props);
        this.state = {jsonData: ''};
    }

    componentWillMount() {
        fetch(API)
            .then(response => response.json())
            .then(data => this.setState({jsonData: data.items}))
            .catch((error) => {
                console.error(error);
            });
    }


    createServicesetComponent(elem, list){
        elem.list = list;
        return <ProjectServiceset serviceset={elem}/>
    }

    render() {

        if (this.state.jsonData !== '') {

            var servicesetElem = true;
            if(this.state.jsonData.serviceset.length != 0) {
                servicesetElem = this.state.jsonData.serviceset.map(
                    (elem) => this.createServicesetComponent(elem, this.state.jsonData.stateList)
                );
            }

            return (
                <div>
                    <ProjectInfo projectInfo = {this.state.jsonData.project}/>
                    <AddButton buttonInfo = {{buttonName: "Создать набор", path: "#"}}/>
                    <ProjectEvent event = {this.state.jsonData.event}/>
                    <div className={"col-md-12"}>{servicesetElem}</div>
                </div>
            );
        } else {
            return (
                <div></div>
            );
        }
    }
}


export default ProjectView;