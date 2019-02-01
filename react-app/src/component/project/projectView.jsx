import React, {Component} from 'react';
import ProjectInfo from './projectInfo.jsx';
import AddButton from '../button/addButton.jsx';
import ProjectServiceset from './projectServiceset.jsx';
import ProjectEvent from './projectEvent.jsx';

class ProjectView extends Component {

    constructor(props) {
        super(props);
        this.state = {jsonData: ''};
    }

    componentWillMount() {
        fetch(this.getProjectUrl())
            .then(response => response.json())
            .then(data => this.setState({jsonData: data.items}))
            .catch((error) => {
                console.error(error);
            });
    }


    getProjectUrl() {
        var id = this.props.match.params.id_project;
        var API = '/api/projects/' + id;
        return API;
    }


    createServicesetComponent(elem, list) {
        elem.list = list;
        return <ProjectServiceset serviceset={elem}/>
    }

    render() {

        if (this.state.jsonData !== '') {
            var servicesetElem = true;
            if (this.state.jsonData.serviceset.length !== 0) {
                servicesetElem = this.state.jsonData.serviceset.map(
                    (elem) => this.createServicesetComponent(elem, this.state.jsonData.stateList)
                );
            }

            return (
                <div className={"container"}>
                    <ProjectInfo projectInfo={this.state.jsonData.project}/>
                    <ProjectEvent event={this.state.jsonData.event}/>
                        <div className={"col-md-12 set_container"}>
                        <AddButton buttonInfo={{buttonName: "Создать пакет", path: "/servicesetCreate"}}/>
                        <div>{servicesetElem}</div>
                    </div>
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