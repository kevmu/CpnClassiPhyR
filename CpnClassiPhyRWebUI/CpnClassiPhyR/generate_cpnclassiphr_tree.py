#!/usr/bin/python
from subprocess import Popen, PIPE
from Bio import Phylo

# Need to set matplotlib to use 'Agg' so that xwindows is not active and gel images can be generated.
import matplotlib
matplotlib.use('Agg')
import networkx, pylab


import argparse

import os
import sys
import re
import csv
import shutil

from Bio import SeqIO

python_path = sys.argv[0]
app_dir = os.path.dirname(os.path.realpath(python_path))
sys.path.append(os.path.abspath(app_dir))

parser = argparse.ArgumentParser()

fasta_infile = None
subgroups_phylo_infile = None
output_dir = None

parser.add_argument('-i', action='store', dest='fasta_infile',
                    help='fasta file as input. (i.e. filename.fasta)')
parser.add_argument('-s', action='store', dest='subgroups_phylo_infile',
                    help='fasta file as input. (i.e. filename.fasta)')
parser.add_argument('-o', action='store', dest='output_dir',
                    help='output directory as input. (i.e. $HOME)')

parser.add_argument('--version', action='version', version='%(prog)s 1.0')

results = parser.parse_args()

fasta_infile = results.fasta_infile
subgroups_phylo_infile = results.subgroups_phylo_infile
output_dir = results.output_dir

if(fasta_infile == None):
    print('\n')
    print('error: please use the -i option to specify the fasta file as input')
    print('fasta_infile =' + ' ' + str(fasta_infile))
    print('\n')
    parser.print_help()
    sys.exit(1)
if(subgroups_phylo_infile == None):
    print('\n')
    print('error: please use the -s option to specify the fasta file as input')
    print('subgroups_phylo_infile =' + ' ' + str(subgroups_phylo_infile))
    print('\n')
    parser.print_help()
    sys.exit(1)
if(output_dir == None):
    print('\n')
    print('error: please use the -o option to specify the output directory as input')
    print('output_dir =' + ' ' + str(output_dir))
    print('\n')
    parser.print_help()
    sys.exit(1)


if not os.path.exists(output_dir):
    os.makedirs(output_dir)

megacc = '/usr/bin/megacc';

mega_align_options_infile = os.path.join(app_dir, 'config', 'clustalw_align.mao')
shutil.copy2(mega_align_options_infile, output_dir)

#mega_tree_options_infile = os.path.join(app_dir, 'config', 'tree_builder_specs.mao')

mega_tree_options_infile = os.path.join(app_dir, 'config', 'NJ_nucleotide.mao')
shutil.copy2(mega_tree_options_infile, output_dir)

#mega_tree_options_infile = os.path.join(app_dir, 'config', 'MP-MEGA.mao')
#mega_tree_options_infile = os.path.join(app_dir, 'config', 'ML-MEGA.mao')



fasta_basename = os.path.basename(fasta_infile)
(filename, ext) = os.path.splitext(fasta_basename)


mega_align_filename = os.path.join(output_dir, filename + '_' + 'clustalw_align')
mega_tree_filename = os.path.join(output_dir, filename + '_' + 'mega_tree')

tree_seqsfile = os.path.join(output_dir, 'tree_seqsfile.fasta')
CpnIdentiPhyR_tree_file = os.path.join(output_dir, 'CpnIdentiPhyR_tree_sequences.fasta')

sequence_ids_outfile = os.path.join(output_dir, 'sequence_ids.csv')
f = open(sequence_ids_outfile, 'w')
sequence_ids_output_file = csv.writer(f)


f_out = open(tree_seqsfile, 'w')
for fasta_record in SeqIO.parse(fasta_infile, "fasta"):
    seq_id = fasta_record.id
    description = fasta_record.description
    fasta_record.description = seq_id
    sequence_ids_output_file.writerow([seq_id, description, "reference"])
    
    r = SeqIO.write(fasta_record, f_out, 'fasta')
    
    if(r != 1):
        print('Error while writing sequence:  ' + seq_record.id)

for fasta_record in SeqIO.parse(subgroups_phylo_infile, "fasta"):
    seq_id = fasta_record.id
    description = fasta_record.description
    fasta_record.description = seq_id
    sequence_ids_output_file.writerow([seq_id, description, "reference"])

    r = SeqIO.write(fasta_record, f_out, 'fasta')
    
    if(r != 1):
        print('Error while writing sequence:  ' + seq_record.id)

f_out.close()
f.close()

#megacc -d phylo_phyto_tree.fasta -a clustalw_align.mao -o megacc_test.txt
megacc_align_cmd = " ".join([megacc, "-d", tree_seqsfile, "-a", mega_align_options_infile, "-o", mega_align_filename])
print(megacc_align_cmd)

p1 = Popen(megacc_align_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
(megacc_align_results, err) = p1.communicate()
p1_status = p1.wait()

megacc_align_output = megacc_align_results.decode("utf-8")
print(megacc_align_output)
print(err.decode("utf-8"))
print(p1_status)

f = open(sequence_ids_outfile, 'r')
sequence_ids_output_file = csv.reader(f)
sequence_header_list = {}
for entry in sequence_ids_output_file:
    sequence_id = entry[0]
    description = entry[1]
    seq_type = entry[2]
    sequence_header_list[sequence_id] = [description, seq_type]
f.close()

if(p1_status == 0):
    mega_align_infile = mega_align_filename + '.meg'
    print(mega_align_infile)


    
    mega_best_tree_infile = mega_tree_filename + '.nwk'
    print(mega_best_tree_infile)
    
    mega_consensus_tree_infile = mega_tree_filename + '_' + 'consensus.nwk'
    print(mega_consensus_tree_infile)
    
    #megacc -d megacc_test.meg -a tree_builder_specs.mao  -o ML-Test-2018-07-14.txt
    megacc_tree_cmd = " ".join([megacc, "-d", mega_align_infile, "-a", mega_tree_options_infile, "-o", mega_tree_filename])
    print(megacc_tree_cmd)
    p2 = Popen(megacc_tree_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
    (megacc_tree_results, err) = p2.communicate()
    p2_status = p2.wait()

    megacc_tree_output = megacc_tree_results.decode("utf-8")
    print(megacc_tree_output)
    print(err.decode("utf-8"))
    print(p2_status)

    if(p2_status == 0):


        best_tree = Phylo.read(mega_best_tree_infile, 'newick')
        print(best_tree)
        
        best_tree.root_with_outgroup({'name': 'b30065'})
        best_tree.rooted = True
        
        Phylo.draw(best_tree)
        pylab.savefig(mega_tree_filename + '.png')

        for clade in best_tree.get_terminals():
            key = clade.name
            
            description = sequence_header_list[key][0]
            seq_type = sequence_header_list[key][1]
            
#            if(seq_type == 'input'):
#                clade.color = 'red'

            clade.name = description
        
        Phylo.write(best_tree, mega_tree_filename + '.nwk', 'newick')
        Phylo.write(best_tree, mega_tree_filename + '.xml', 'phyloxml')
        
        f_out = open(CpnIdentiPhyR_tree_file, 'w')
        for fasta_record in SeqIO.parse(tree_seqsfile, "fasta"):
            seq_id = fasta_record.id
            fasta_record.description = sequence_header_list[seq_id][0]
                
            r = SeqIO.write(fasta_record, f_out, 'fasta')
                
            if(r != 1):
                print('Error while writing sequence:  ' + seq_record.id)
        f_out.close()

