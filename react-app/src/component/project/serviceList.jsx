import React, {Component} from 'react';
import ServiceListItem from './serviceListItem.jsx';


class ServiceList extends Component {

    render() {
        if(this.props.list !== ''){
            return (
                <div className={"servicelist"}>
                    <table>
                        <tr className={"table-header"}>
                            <td>Услуга</td>
                            <td>Стоимость</td>
                        </tr>
                        {
                            this.props.list.map((item) => <ServiceListItem item = {item}/>)
                        }
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