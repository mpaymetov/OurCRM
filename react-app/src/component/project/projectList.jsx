import React, {Component} from 'react';
import {Link, BrowserRouter, BrowserRouter as Router, Route} from 'react-router-dom';

const API = '/api/projects';

class ProjectList extends Component {
    constructor(props) {
        super(props);
        this.state = {jsonData: ''};
    }

    componentWillMount() {
        fetch(API)
            .then(response => response.json())
            .then(data => this.setState({jsonData: data}))
            .catch((error) => {
                console.error(error);
            });
    }
    
    render() {
        if (this.state.jsonData !== '') {

            return(
                <div className={"set_list"}>
                    <table className={"table"}>
                        <thead>
                        <tr>
                            <td>Проект</td>
                            <td>Клиент</td>
                            <td>Дата создания</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        {this.state.jsonData.items.map(
                            (elem) => <tr>
                                <td>{elem.name}</td>
                                <td>{elem.client.name}</td>
                                <td>{elem.creation_date}</td>
                                <td><Link to={"/projectsView/" + elem.id_project}>Подробнее</Link></td>
                            </tr>
                        )}
                        </tbody>
                    </table>
                </div>
            );
        } else {
            return(
                <div></div>
            );
        }
        
    }

}

export default ProjectList;