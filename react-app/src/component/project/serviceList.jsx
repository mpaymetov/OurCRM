import React, {Component} from 'react';
import ServiceListItem from './serviceListItem.jsx';


class ServiceList extends Component {

    render() {
        if(this.props.list !== ''){
            return (
                <div className={"servicelist"}>
                    <table className={"table"}>
                        <thead>
                        <tr>
                            <td>Услуга</td>
                            <td>Стоимость</td>
                        </tr>
                        </thead>
                        <tbody>{this.props.list.map((item) => <ServiceListItem item = {item}/>)}</tbody>
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

export default ServiceList;