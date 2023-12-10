import { readFileSync, promises as fsPromises } from 'fs';
const list: string[] = readFileSync('inputs/day1list.txt', 'utf-8').split('\n');


//Part 1
var sum: number = 0;
for (let i = 0; i < list.length; i++) {
  let row: any = list[i].replace(/\D/g, '');
  sum = sum + parseInt(row[0] + '' + row[row.length - 1]);
}
console.log("The answer for part 1 is: " + sum);
//Part 2
sum = 0;
for (let i = 0; i < list.length; i++) {
  let row: any = list[i].replaceAll('one', 'o1e');
  row = row.replaceAll('two', 't2o');
  row = row.replaceAll('three', 't3e');
  row = row.replaceAll('four', 'f4r');
  row = row.replaceAll('five', 'f5e');
  row = row.replaceAll('six', 's6x');
  row = row.replaceAll('seven', 's7n');
  row = row.replaceAll('eight', 'e8t');
  row = row.replaceAll('nine', 'n9e');
  row = row.replace(/\D/g, '');
  sum = sum + parseInt(row[0] + '' + row[row.length - 1]);
}
console.log("The answer for part 2 is: " + sum)