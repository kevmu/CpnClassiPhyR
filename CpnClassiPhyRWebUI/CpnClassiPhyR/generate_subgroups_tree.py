#!/usr/bin/python
import os
import sys
import re
import csv
import argparse
import shutil

from subprocess import Popen, PIPE
from Bio import Phylo

import networkx, pylab

from Bio import SeqIO
# Sample Command 
# python3.5 generate_subgroups_tree.py -i /var/www/CpnClassiPhyRWebUI/CpnClassiPhyR/db/cpn60_UT_phytoplasma_subgroups.fasta -g /var/www/CpnClassiPhyRWebUI/CpnClassiPhyR/db/acholeplasma_laidlawii_PG8R10_outgroup.fasta -o /var/www/CpnClassiPhyRWebUI/CpnClassiPhyR/subgroup_metadata/phylogenetics

# Path to the mega10 command line package.
#megacc = '/usr/local/bin/megacc'

megacc = '/usr/bin/megacc';

# Path to the application files.
python_path = sys.argv[0]
app_dir = os.path.dirname(os.path.realpath(python_path))
#app_dir = "/Users/kmuirhead/Desktop/CpnClassiPhyR/"
sys.path.append(os.path.abspath(app_dir))

# Path to the mega options files.
config_dir = os.path.join(app_dir, 'config')

parser = argparse.ArgumentParser()

fasta_infile = None
outgroups_infile = None
output_dir = None

parser.add_argument('-i', action='store', dest='fasta_infile',
                    help='fasta file as input. (i.e. filename.fasta)')
parser.add_argument('-g', action='store', dest='outgroups_infile',
                    help='fasta file as input. (i.e. filename.fasta)')
parser.add_argument('-o', action='store', dest='output_dir',
                    help='output directory as input. (i.e. $HOME)')

parser.add_argument('--version', action='version', version='%(prog)s 1.0')

results = parser.parse_args()

fasta_infile = results.fasta_infile
outgroups_infile = results.outgroups_infile
output_dir = results.output_dir

if(fasta_infile == None):
    print('\n')
    print('error: please use the -i option to specify the fasta file as input')
    print('fasta_infile =' + ' ' + str(fasta_infile))
    print('\n')
    parser.print_help()
    sys.exit(1)
if(outgroups_infile == None):
    print('\n')
    print('error: please use the -g option to specify the fasta file as input')
    print('outgroups_infile =' + ' ' + str(outgroups_infile))
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

mega_align_options_infile = os.path.join(config_dir,'clustalw_align.mao')
mega_align_filename = os.path.join(output_dir,'subgroups_clustalw_align')

mega_tree_filename = os.path.join(output_dir, 'subgroups_mega_tree')

subgroups_tree_outfile = os.path.join(output_dir, 'subgroups_tree_output.fasta')
subgroups_tree_file = os.path.join(output_dir, 'subgroups_tree.fasta')

sequence_ids_outfile = os.path.join(output_dir, 'sequence_ids.csv')
f = open(sequence_ids_outfile, 'w')
sequence_ids_output_file = csv.writer(f)

f_out = open(subgroups_tree_file, 'w')
for fasta_record in SeqIO.parse(fasta_infile, "fasta"):
    seq_id = fasta_record.id
    description = fasta_record.description
    #fasta_record.description = seq_id
    sequence_ids_output_file.writerow([seq_id, description, "reference"])
    
    #print(fasta_record)
    # sys.exit()
    r = SeqIO.write(fasta_record, f_out, 'fasta')
    
    if(r != 1):
        print('Error while writing sequence:  ' + seq_record.id)

for fasta_record in SeqIO.parse(outgroups_infile, "fasta"):
    seq_id = fasta_record.id
    description = fasta_record.description
    #fasta_record.description = seq_id
    sequence_ids_output_file.writerow([seq_id, description, "reference"])
    
    r = SeqIO.write(fasta_record, f_out, 'fasta')
    
    if(r != 1):
        print('Error while writing sequence:  ' + seq_record.id)

f_out.close()
f.close()

#megacc -d phylo_phyto_tree.fasta -a clustalw_align.mao -o megacc_test.txt
megacc_align_cmd = " ".join([megacc, "-d", subgroups_tree_file, "-a", mega_align_options_infile, "-o", mega_align_filename])
print(megacc_align_cmd)
p1 = Popen(megacc_align_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
(megacc_align_results, err) = p1.communicate()
p1_status = p1.wait()

megacc_align_output = megacc_align_results.decode("utf-8")
print(megacc_align_output)
print(err.decode("utf-8"))
print(p1_status)

if(p1_status == 0):
    mega_align_file = mega_align_filename + '.meg'
    print(mega_align_file)

    #mega_tree_options_infile = '/home/muirheadk/tree_builder_specs.mao'
    #mega_tree_options_infile = '/home/muirheadk/neighbor-joining-tree-params.mao'
    #mega_tree_options_infile = '/home/muirheadk/MP-MEGA.mao'
    mega_tree_options_infile = os.path.join(config_dir,'NJ_nucleotide.mao')
    mega_tree_filename = os.path.join(output_dir,'subgroups_mega_tree')
    
    mega_best_tree_infile = mega_tree_filename + '.nwk'
    print(mega_best_tree_infile)
    
#    mega_consensus_tree_infile = mega_tree_filename + '_' + 'consensus.nwk'
#    print(mega_consensus_tree_infile)

    #megacc -d megacc_test.meg -a tree_builder_specs.mao  -o ML-Test-2018-07-14.txt
    megacc_tree_cmd = " ".join([megacc, "-d", mega_align_file, "-a", mega_tree_options_infile, "-o", mega_tree_filename])
    print(megacc_tree_cmd)
    p2 = Popen(megacc_tree_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
    (megacc_tree_results, err) = p2.communicate()
    p2_status = p2.wait()

    megacc_tree_output = megacc_tree_results.decode("utf-8")
    print(megacc_tree_output)
    print(err.decode("utf-8"))
    print(p2_status)

    f = open(sequence_ids_outfile, 'r')
    sequence_ids_output_file = csv.reader(f)
    sequence_header_list = {}
    for entry in sequence_ids_output_file:
        sequence_id = entry[0]
        description = entry[1]
        seq_type = entry[2]
        sequence_header_list[sequence_id] = [description, seq_type]
    f.close()

    if(p2_status == 0):


        best_tree = Phylo.read(mega_best_tree_infile, 'newick')
        print(best_tree)
        
        best_tree.root_with_outgroup({'name': 'b30065_LXYB01000004_Acholeplasma_laidlawii_PG8R10'})
        best_tree.rooted = True
        
        #Phylo.draw(best_tree)
        #pylab.savefig(mega_tree_filename + '.png')
        
        Phylo.write(best_tree, mega_tree_filename + '.nwk', 'newick')
        Phylo.write(best_tree, mega_tree_filename + '.xml', 'phyloxml')
        
        f_out = open(subgroups_tree_outfile, 'w')
        for fasta_record in SeqIO.parse(subgroups_tree_file, "fasta"):
            seq_id = fasta_record.id
            fasta_record.description = sequence_header_list[seq_id][0]
            
            r = SeqIO.write(fasta_record, f_out, 'fasta')
            
            if(r != 1):
                print('Error while writing sequence:  ' + seq_record.id)
        f_out.close()


#        consensus_tree = Phylo.read(mega_consensus_tree_infile, 'newick')
#        print(consensus_tree)
#        
#        consensus_tree.root_with_outgroup({'name': 'b30065_LXYB01000004_Acholeplasma_laidlawii_PG8R10'})
#        consensus_tree.rooted = True
#
#        Phylo.draw(consensus_tree)
#        pylab.savefig(mega_tree_filename + '_' + 'consensus.png')
#
#        Phylo.write(consensus_tree, mega_tree_filename + '_' + 'consensus.nwk', 'newick')
#        Phylo.write(consensus_tree, mega_tree_filename  + '_' + 'consensus.xml', 'phyloxml')
